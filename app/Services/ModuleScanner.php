<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use Carbon\Carbon;
use App\Models\Generator;
use Filament\Resources\Resource;
use Filament\Pages\Page;
use Filament\Widgets\Widget;
use Livewire\Component;

/**
 * ModuleScanner Service
 *
 * Comprehensive scanning service that identifies and analyzes all components
 * within a Laravel Filament project, including Resources, Pages, Widgets, and Livewire components.
 */
class ModuleScanner
{
    /**
     * The filesystem instance for file operations
     */
    protected Filesystem $filesystem;

    /**
     * Base application path
     */
    protected string $basePath;

    /**
     * Paths to scan for different component types
     */
    protected array $scanPaths = [
        'resources' => [
            'app/Filament/Resources',
            'app/Filament/Admin/Resources'
        ],
        'pages' => [
            'app/Filament/Pages'
        ],
        'widgets' => [
            'app/Filament/Widgets'
        ],
        'livewire' => [
            'app/Http/Livewire',
            'app/Livewire'
        ]
    ];

    /**
     * Cached results of all discovered components
     */
    protected array $components = [];

    /**
     * Mapping of base class types to component categories
     */
    protected array $baseClassMap = [
        Resource::class => 'resources',
        Page::class => 'pages',
        Widget::class => 'widgets',
        Component::class => 'livewire'
    ];

    /**
     * Create a new ModuleScanner service instance
     */
    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->basePath = base_path();
        $this->resetComponents();
    }

    /**
     * Reset the components array with empty categories
     */
    public function resetComponents(): void
    {
        $this->components = [
            'resources' => [],
            'pages' => [],
            'widgets' => [],
            'livewire' => []
        ];
    }

    /**
     * Perform a comprehensive scan of all component types
     *
     * @return array The discovered components organized by type
     */
    public function scan(): array
    {
        $this->resetComponents();
        
        // Scan each component type
        $this->scanResources();
        $this->scanPages();
        $this->scanWidgets();
        $this->scanLivewireComponents();
        
        // Mark components created by the Generator
        $this->identifyGeneratedComponents();
        
        // Sort components by modification date (newest first)
        foreach ($this->components as $type => $components) {
            $this->components[$type] = collect($components)
                ->sortByDesc('last_modified')
                ->values()
                ->toArray();
        }
        
        return $this->components;
    }

    /**
     * Scan files by pattern in specified paths
     *
     * @param array $paths Directories to scan
     * @param string $pattern File name pattern to match
     * @return Collection Collection of file info objects
     */
    protected function scanFiles(array $paths, string $pattern): Collection
    {
        $files = collect();
        
        foreach ($paths as $path) {
            $fullPath = $this->basePath . '/' . $path;
            
            if ($this->filesystem->exists($fullPath)) {
                $pathFiles = collect($this->filesystem->allFiles($fullPath))
                    ->filter(fn ($file) => Str::endsWith($file->getFilename(), $pattern));
                
                $files = $files->merge($pathFiles);
            }
        }
        
        return $files;
    }

    /**
     * Scan for Filament Resources
     */
    protected function scanResources(): void
    {
        $files = $this->scanFiles($this->scanPaths['resources'], 'Resource.php');
        
        foreach ($files as $file) {
            $component = $this->analyzeComponentFile($file, 'resources');
            if ($component) {
                $this->components['resources'][] = $component;
            }
        }
    }

    /**
     * Scan for Filament Pages
     */
    protected function scanPages(): void
    {
        $files = $this->scanFiles($this->scanPaths['pages'], '.php');
        
        // Filter out files that are likely not Page classes (interfaces, traits, etc.)
        $files = $files->filter(function ($file) {
            $filename = $file->getFilename();
            return !Str::contains($filename, ['Interface', 'Trait', 'Abstract', 'Contract']);
        });
        
        foreach ($files as $file) {
            $component = $this->analyzeComponentFile($file, 'pages');
            if ($component) {
                $this->components['pages'][] = $component;
            }
        }
    }

    /**
     * Scan for Filament Widgets
     */
    protected function scanWidgets(): void
    {
        $files = $this->scanFiles($this->scanPaths['widgets'], '.php');
        
        // Filter out files that are likely not Widget classes
        $files = $files->filter(function ($file) {
            $filename = $file->getFilename();
            return !Str::contains($filename, ['Interface', 'Trait', 'Abstract', 'Contract']);
        });
        
        foreach ($files as $file) {
            $component = $this->analyzeComponentFile($file, 'widgets');
            if ($component) {
                $this->components['widgets'][] = $component;
            }
        }
    }

    /**
     * Scan for Livewire Components
     */
    protected function scanLivewireComponents(): void
    {
        $files = $this->scanFiles($this->scanPaths['livewire'], '.php');
        
        // Filter out files that are likely not Livewire component classes
        $files = $files->filter(function ($file) {
            $filename = $file->getFilename();
            return !Str::contains($filename, ['Interface', 'Trait', 'Abstract', 'Contract']);
        });
        
        foreach ($files as $file) {
            $component = $this->analyzeComponentFile($file, 'livewire');
            if ($component) {
                $this->components['livewire'][] = $component;
            }
        }
    }

    /**
     * Analyze a component file and extract metadata
     *
     * @param \SplFileInfo $file The file to analyze
     * @param string $expectedType The expected component type
     * @return array|null Component metadata or null if not a valid component
     */
    protected function analyzeComponentFile(\SplFileInfo $file, string $expectedType): ?array
    {
        // Get the file's relative path
        $relativePath = str_replace($this->basePath . '/', '', $file->getRealPath());
        
        // Extract the class name
        $className = $file->getBasename('.php');
        
        // Determine the namespace and full class name
        $namespace = $this->getNamespaceFromPath($relativePath);
        $fullClassName = $namespace . '\\' . $className;
        
        // Initialize component metadata
        $componentData = [
            'class' => $fullClassName,
            'name' => $className,
            'path' => $relativePath,
            'type' => $expectedType,
            'edit_url' => '#',
            'generator_url' => '#',
            'source' => 'ידני', // Manual source by default
            'exists' => class_exists($fullClassName),
            'is_active' => class_exists($fullClassName),
            'is_generated' => false,
            'last_modified' => Carbon::createFromTimestamp($file->getMTime())->format('Y-m-d H:i:s'),
            'metadata' => []
        ];
        
        // If the class exists, analyze it further
        if (class_exists($fullClassName)) {
            // Verify that it's the expected component type
            $actualType = $this->determineComponentType($fullClassName);
            
            // Only continue if the component matches the expected type
            if ($actualType === $expectedType) {
                // Extract and add metadata based on component type
                $componentData['metadata'] = $this->extractComponentMetadata($fullClassName, $expectedType);
                
                // Set the edit URL if applicable
                $componentData['edit_url'] = $this->generateEditUrl($fullClassName, $expectedType);
                
                // Return the component data
                return $componentData;
            }
        } else {
            // The class doesn't exist, but we'll still include it in the results
            // This is helpful for identifying broken/missing components
            return $componentData;
        }
        
        return null;
    }

    /**
     * Extract the namespace from a file path
     *
     * @param string $path Relative file path
     * @return string The corresponding namespace
     */
    protected function getNamespaceFromPath(string $path): string
    {
        // Extract directory without file name
        $directory = dirname($path);
        
        // Convert directory separators to namespace separators
        $namespace = str_replace('/', '\\', $directory);
        
        // Remove 'app' prefix and add 'App' namespace
        $namespace = 'App\\' . ltrim(str_replace('app', '', $namespace), '\\');
        
        return $namespace;
    }

    /**
     * Determine the component type based on class inheritance
     *
     * @param string $className The full class name to analyze
     * @return string|null The component type or null if not recognized
     */
    protected function determineComponentType(string $className): ?string
    {
        if (!class_exists($className)) {
            return null;
        }
        
        try {
            $reflection = new ReflectionClass($className);
            
            // Check inheritance against known base classes
            foreach ($this->baseClassMap as $baseClass => $type) {
                if ($reflection->isSubclassOf($baseClass) || $className === $baseClass) {
                    return $type;
                }
            }
            
            // Special case for Livewire components
            if (str_contains($className, 'Livewire\\') || str_contains($className, '\\Livewire\\')) {
                return 'livewire';
            }
        } catch (\Exception) {
            // If reflection fails, we can't determine the type
            return null;
        }
        
        return null;
    }

    /**
     * Extract metadata specific to the component type
     *
     * @param string $className The full class name
     * @param string $type The component type
     * @return array Component-specific metadata
     */
    protected function extractComponentMetadata(string $className, string $type): array
    {
        $metadata = [];
        
        try {
            $reflection = new ReflectionClass($className);
            
            switch ($type) {
                case 'resources':
                    // Get model class
                    if ($reflection->hasProperty('model')) {
                        $modelProperty = $reflection->getProperty('model');
                        $modelProperty->setAccessible(true);
                        $metadata['model'] = $modelProperty->getValue();
                    }
                    
                    // Get navigation group
                    if ($reflection->hasProperty('navigationGroup')) {
                        $property = $reflection->getProperty('navigationGroup');
                        $property->setAccessible(true);
                        $metadata['navigation_group'] = $property->getValue();
                    }
                    
                    // Get model label
                    if ($reflection->hasProperty('modelLabel')) {
                        $property = $reflection->getProperty('modelLabel');
                        $property->setAccessible(true);
                        $metadata['model_label'] = $property->getValue();
                    }
                    
                    // Check if it has a table method
                    $metadata['has_table'] = $reflection->hasMethod('table');
                    
                    // Check if it has a form method
                    $metadata['has_form'] = $reflection->hasMethod('form');
                    
                    // Check if getPages method exists
                    $metadata['has_pages'] = $reflection->hasMethod('getPages');
                    
                    break;
                    
                case 'pages':
                    // Get navigation icon
                    if ($reflection->hasProperty('navigationIcon')) {
                        $property = $reflection->getProperty('navigationIcon');
                        $property->setAccessible(true);
                        $metadata['icon'] = $property->getValue();
                    }
                    
                    // Get page title
                    if ($reflection->hasProperty('title')) {
                        $property = $reflection->getProperty('title');
                        $property->setAccessible(true);
                        $metadata['title'] = $property->getValue();
                    }
                    
                    // Get slug
                    if ($reflection->hasProperty('slug')) {
                        $property = $reflection->getProperty('slug');
                        $property->setAccessible(true);
                        $metadata['slug'] = $property->getValue();
                    } else {
                        $metadata['slug'] = Str::slug(class_basename($className));
                    }
                    
                    // Check if it has a render method
                    $metadata['has_render'] = $reflection->hasMethod('render');
                    
                    // Get view path
                    if ($reflection->hasProperty('view')) {
                        $property = $reflection->getProperty('view');
                        $property->setAccessible(true);
                        $metadata['view'] = $property->getValue();
                    }
                    
                    break;
                    
                case 'widgets':
                    // Check for polling
                    if ($reflection->hasProperty('polling')) {
                        $property = $reflection->getProperty('polling');
                        $property->setAccessible(true);
                        $metadata['polling'] = $property->getValue();
                    }
                    
                    // Get polling interval
                    if ($reflection->hasProperty('pollingInterval')) {
                        $property = $reflection->getProperty('pollingInterval');
                        $property->setAccessible(true);
                        $metadata['polling_interval'] = $property->getValue();
                    }
                    
                    // Get widget view
                    if ($reflection->hasProperty('view')) {
                        $property = $reflection->getProperty('view');
                        $property->setAccessible(true);
                        $metadata['view'] = $property->getValue();
                    }
                    
                    break;
                    
                case 'livewire':
                    // Get component view
                    if ($reflection->hasMethod('render')) {
                        $metadata['has_render'] = true;
                        
                        // Try to extract view name if using a view method
                        $renderMethod = $reflection->getMethod('render');
                        $metadata['has_view'] = str_contains($renderMethod->getDocComment() ?: '', '@return \Illuminate\View\View');
                    }
                    
                    // Check if uses a layout
                    $metadata['uses_layout'] = false;
                    foreach ($reflection->getMethods() as $method) {
                        if (str_contains($method->getDocComment() ?: '', '@return void')) {
                            $methodBody = $this->filesystem->get($reflection->getFileName());
                            if (preg_match('/this->layout\([\'"](.*?)[\'"]\)/m', $methodBody, $matches)) {
                                $metadata['uses_layout'] = true;
                                $metadata['layout'] = $matches[1];
                            }
                        }
                    }
                    
                    break;
            }
        } catch (\Exception $e) {
            // In case of reflection errors, return minimal metadata
            $metadata['error'] = $e->getMessage();
        }
        
        return $metadata;
    }

    /**
     * Generate appropriate edit URL for the component
     *
     * @param string $className The full class name
     * @param string $type The component type
     * @return string The edit URL
     */
    protected function generateEditUrl(string $className, string $type): string
    {
        try {
            if ($type === 'resources') {
                // For resources, link to the resource index page
                $resourceName = Str::of(class_basename($className))->kebab();
                if (Str::endsWith($resourceName, '-resource')) {
                    $resourceName = Str::beforeLast($resourceName, '-resource');
                }
                // Pluralize the resource name for the route
                $resourceName = Str::plural($resourceName);
                // First try admin panel route
                $adminRoute = "filament.admin.resources.{$resourceName}.index";
                if (route_has($adminRoute)) {
                    return route($adminRoute);
                }
                // Fallback to default panel route
                $defaultRoute = "filament.resources.{$resourceName}.index";
                if (route_has($defaultRoute)) {
                    return route($defaultRoute);
                }
            } elseif ($type === 'pages') {
                // For pages, try to determine the page URL based on slug
                $reflection = new ReflectionClass($className);
                if ($reflection->hasProperty('slug')) {
                    $property = $reflection->getProperty('slug');
                    $property->setAccessible(true);
                    $slug = $property->getValue();
                    
                    if ($slug) {
                        return url("/admin/{$slug}");
                    }
                }
                // Fallback to slug based on class name
                $slug = Str::slug(class_basename($className));
                return url("/admin/{$slug}");
            }
        } catch (\Exception) {
            // Fallback for any errors
        }
        
        return '#';
    }

    /**
     * Identify components that were created by the Generator
     */
    protected function identifyGeneratedComponents(): void
    {
        try {
            // Get all generators
            $generators = Generator::all();
            
            foreach ($generators as $generator) {
                // Try to match generators to discovered components
                $targetPath = $generator->target_path;
                $relativePath = str_replace($this->basePath . '/', '', $targetPath);
                
                foreach ($this->components as $type => $componentList) {
                    foreach ($componentList as $index => $component) {
                        if ($component['path'] === $relativePath) {
                            $this->components[$type][$index]['is_generated'] = true;
                            $this->components[$type][$index]['source'] = 'מחולל';
                            $this->components[$type][$index]['generator_url'] = route('filament.admin.resources.generators.edit', $generator);
                        }
                    }
                }
            }
        } catch (\Exception) {
            // If there's an error accessing generators, continue without marking
        }
    }

    /**
     * Helper function to check if a route exists
     *
     * @param string $name Route name to check
     * @return bool Whether the route exists
     */
    protected function routeExists(string $name): bool
    {
        try {
            return route($name) !== null;
        } catch (\Exception) {
            return false;
        }
    }
}

/**
 * Helper function to check if a route exists
 */
if (!function_exists('route_has')) {
    function route_has(string $name): bool
    {
        try {
            route($name);
            return true;
        } catch (\Exception) {
            return false;
        }
    }
}