<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

class GenerateUiMapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ui:map
                            {--output=resources/docs/interface-map.md : Output file path}
                            {--diagram=resources/docs/interface-graph.svg : Diagram output file path}
                            {--relations=resources/docs/interface-relations.json : Relations JSON file path}
                            {--format=markdown : Output format (markdown, json, html)}
                            {--include-models : Include model references and relationships}
                            {--include-filament : Include Filament resources and pages}
                            {--include-livewire : Include Livewire components}
                            {--analyze-views : Analyze blade templates}
                            {--public-routes : Include public routes}
                            {--admin-routes : Include admin routes}
                            {--extract-titles : Extract page titles from blade templates}
                            {--extract-sections : Extract named sections from templates}
                            {--show-middleware : Show middleware for routes}
                            {--show-bindings : Show variable bindings}
                            {--cross-link-models : Show model usage across views}
                            {--add-recommendations : Add optimization tips}
                            {--deduplicate : Remove duplicate entries}
                            {--use-relative-paths : Use relative paths instead of absolute}
                            {--generate-visual-graph : Generate a visual graph}
                            {--generate-cross-relation-table : Generate a cross-relation table}
                            {--graph-style=hierarchical : Graph style (hierarchical, radial, force-directed)}
                            {--ignore-pattern= : Comma-separated list of file patterns to ignore}
                            {--i18n-map : Link views to translation files}
                            {--rtl-support : Detect RTL-compatible templates}
                            {--silent : Suppress output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a UI interface map, graphical diagram, and relation table for the Laravel application';

    /**
     * Array to store all routes data
     */
    protected $routes = [];

    /**
     * Array to store all views data
     */
    protected $views = [];

    /**
     * Array to store all controllers data
     */
    protected $controllers = [];

    /**
     * Array to store all models data
     */
    protected $models = [];

    /**
     * Array to store all Filament resources data
     */
    protected $filamentResources = [];

    /**
     * Array to store all Livewire components data
     */
    protected $livewireComponents = [];

    /**
     * Array of glob patterns to ignore
     */
    protected $ignorePatterns = [];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! $this->option('silent')) {
            $this->info('Generating UI Interface Map...');
        }

        // Process ignore patterns
        $ignorePattern = $this->option('ignore-pattern');
        if (! empty($ignorePattern)) {
            $this->ignorePatterns = explode(',', $ignorePattern);
            $this->ignorePatterns = array_map('trim', $this->ignorePatterns);

            if (! $this->option('silent')) {
                $this->info('Ignoring files matching patterns: ' . implode(', ', $this->ignorePatterns));
            }
        }

        // Collect all routes and their metadata
        $this->collectRoutes();

        // Collect and analyze views if option is enabled
        if ($this->option('analyze-views')) {
            $this->collectViews();
        }

        // Collect models if option is enabled
        if ($this->option('include-models')) {
            $this->collectModels();
        }

        // Collect Filament resources if option is enabled
        if ($this->option('include-filament')) {
            $this->collectFilamentResources();
        }

        // Collect Livewire components if option is enabled
        if ($this->option('include-livewire')) {
            $this->collectLivewireComponents();
        }

        // Apply deduplication if enabled
        if ($this->option('deduplicate')) {
            $this->deduplicateEntries();
        }

        // Generate the map in the requested format
        $map = $this->generateMap();

        // Save the map to the specified output file
        $outputPath = $this->option('output');
        $outputDir = dirname(base_path($outputPath));

        // Create directory if it doesn't exist
        if (! File::isDirectory($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }

        File::put(base_path($outputPath), $map);

        if (! $this->option('silent')) {
            $this->info("UI Interface Map generated successfully at: {$outputPath}");
        }

        // Generate the relations JSON file if enabled
        if ($this->option('generate-cross-relation-table')) {
            $relations = $this->generateRelationsJson();
            $relationsPath = $this->option('relations');
            $relationsDir = dirname(base_path($relationsPath));

            // Create directory if it doesn't exist
            if (! File::isDirectory($relationsDir)) {
                File::makeDirectory($relationsDir, 0755, true);
            }

            File::put(base_path($relationsPath), $relations);

            if (! $this->option('silent')) {
                $this->info("Interface relations JSON generated successfully at: {$relationsPath}");
            }
        }

        // Generate the visual graph if enabled
        if ($this->option('generate-visual-graph')) {
            $diagram = $this->generateVisualDiagram();
            $diagramPath = $this->option('diagram');
            $diagramDir = dirname(base_path($diagramPath));

            // Create directory if it doesn't exist
            if (! File::isDirectory($diagramDir)) {
                File::makeDirectory($diagramDir, 0755, true);
            }

            File::put(base_path($diagramPath), $diagram);

            if (! $this->option('silent')) {
                $this->info("Visual diagram generated successfully at: {$diagramPath}");
            }
        }

        return 0;
    }

    /**
     * Collect all routes from the application
     */
    protected function collectRoutes()
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $uri = $route->uri();
            $methods = $route->methods();
            $name = $route->getName();
            $action = $route->getAction();

            // Skip closure-based routes
            if (! isset($action['controller']) || $action['controller'] instanceof \Closure) {
                continue;
            }

            // Check if it's a public or admin route
            $isAdminRoute = Str::contains($uri, 'admin') ||
                           Str::contains($uri, 'filament') ||
                           (isset($action['prefix']) && Str::contains($action['prefix'], 'admin'));

            if (($isAdminRoute && ! $this->option('admin-routes')) ||
                (! $isAdminRoute && ! $this->option('public-routes'))) {
                continue;
            }

            $controller = null;
            $method = null;

            if (isset($action['controller'])) {
                $parts = explode('@', (string) $action['controller']);
                if (count($parts) >= 2) {
                    $controller = $parts[0];
                    $method = $parts[1];
                }
            }

            $middleware = [];
            if ($this->option('show-middleware') && isset($action['middleware'])) {
                $middleware = is_array($action['middleware']) ?
                             $action['middleware'] :
                             [$action['middleware']];
            }

            $this->routes[] = [
                'uri' => $uri,
                'methods' => $methods,
                'name' => $name,
                'controller' => $controller,
                'method' => $method,
                'middleware' => $middleware,
                'is_admin' => $isAdminRoute,
            ];
        }
    }

    /**
     * Collect all views from the application
     */
    protected function collectViews()
    {
        $viewsPath = resource_path('views');
        $files = File::allFiles($viewsPath);

        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && ! $this->shouldIgnoreFile($file->getPathname())) {
                $path = $file->getPathname();
                $relativePath = str_replace($viewsPath . '/', '', $path);
                $viewName = str_replace('/', '.', str_replace('.blade.php', '', $relativePath));

                $content = File::get($path);

                // Extract titles if option is enabled
                $title = null;
                if ($this->option('extract-titles')) {
                    preg_match('/<title>(.*?)<\/title>/s', $content, $titleMatches);
                    if (isset($titleMatches[1]) && ($titleMatches[1] !== '' && $titleMatches[1] !== '0')) {
                        $title = trim($titleMatches[1]);
                    }

                    // Also check for @section('title', '...')
                    preg_match("/@section\('title',\s*'(.*?)'\)/s", $content, $sectionTitleMatches);
                    if (isset($sectionTitleMatches[1]) && ($sectionTitleMatches[1] !== '' && $sectionTitleMatches[1] !== '0')) {
                        $title = trim($sectionTitleMatches[1]);
                    }
                }

                // Extract sections if option is enabled
                $sections = [];
                if ($this->option('extract-sections')) {
                    preg_match_all("/@section\('(.*?)'\)(.*?)@endsection/s", $content, $sectionMatches, PREG_SET_ORDER);
                    foreach ($sectionMatches as $match) {
                        $sections[$match[1]] = true;
                    }
                }

                // Check for RTL support if option is enabled
                $rtlSupport = false;
                if ($this->option('rtl-support')) {
                    $rtlSupport = Str::contains($content, 'dir="rtl"') ||
                                 Str::contains($content, 'direction: rtl') ||
                                 Str::contains($content, 'rtl: true');
                }

                // Check for i18n / translations if option is enabled
                $translations = [];
                if ($this->option('i18n-map')) {
                    preg_match_all("/__\('(.*?)'\)/", $content, $translationMatches);
                    if (isset($translationMatches[1]) && $translationMatches[1] !== []) {
                        $translations = $translationMatches[1];
                    }

                    // Also check for @lang('...')
                    preg_match_all("/@lang\('(.*?)'\)/", $content, $langMatches);
                    if (isset($langMatches[1]) && $langMatches[1] !== []) {
                        $translations = array_merge($translations, $langMatches[1]);
                    }
                }

                $this->views[$viewName] = [
                    'path' => $relativePath,
                    'title' => $title,
                    'sections' => array_keys($sections),
                    'rtl_support' => $rtlSupport,
                    'translations' => $translations,
                    'extends' => $this->extractViewExtends($content),
                    'includes' => $this->extractViewIncludes($content),
                    'components' => $this->extractViewComponents($content),
                ];
            }
        }
    }

    /**
     * Extract the template that a view extends
     */
    protected function extractViewExtends($content)
    {
        preg_match("/@extends\('(.*?)'\)/", (string) $content, $matches);

        return empty($matches[1]) ? null : $matches[1];
    }

    /**
     * Extract the templates that a view includes
     */
    protected function extractViewIncludes($content)
    {
        preg_match_all("/@include\('(.*?)'\)/", (string) $content, $matches);

        return empty($matches[1]) ? [] : $matches[1];
    }

    /**
     * Extract the components that a view uses
     */
    protected function extractViewComponents($content)
    {
        $components = [];

        // Extract x-components
        preg_match_all("/<x-([a-zA-Z0-9\-\.]+)/", (string) $content, $xMatches);
        if (isset($xMatches[1]) && $xMatches[1] !== []) {
            $components = array_merge($components, $xMatches[1]);
        }

        // Extract @component directives
        preg_match_all("/@component\('(.*?)'\)/", (string) $content, $componentMatches);
        if (isset($componentMatches[1]) && $componentMatches[1] !== []) {
            $components = array_merge($components, $componentMatches[1]);
        }

        return $components;
    }

    /**
     * Collect all models from the application
     */
    protected function collectModels()
    {
        $modelsPath = app_path('Models');

        if (! File::isDirectory($modelsPath)) {
            return;
        }

        $files = File::allFiles($modelsPath);

        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && ! $this->shouldIgnoreFile($file->getPathname())) {
                $path = $file->getPathname();
                $relativePath = str_replace(app_path() . '/', '', $path);
                $className = str_replace(['.php', '/'], ['', '\\'], $relativePath);
                $fullyQualifiedClassName = 'App\\' . $className;

                if (! class_exists($fullyQualifiedClassName)) {
                    continue;
                }

                try {
                    $reflectionClass = new ReflectionClass($fullyQualifiedClassName);

                    // Skip abstract classes
                    if ($reflectionClass->isAbstract()) {
                        continue;
                    }

                    $relationships = [];
                    $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

                    // Simple heuristic for finding relationship methods
                    foreach ($methods as $method) {
                        // Skip methods inherited from the parent class
                        if ($method->class !== $fullyQualifiedClassName) {
                            continue;
                        }

                        $methodName = $method->getName();
                        $methodContent = File::get($method->getFileName(), false);

                        // Check for common relationship methods
                        if (Str::contains($methodContent, '->hasOne') ||
                            Str::contains($methodContent, '->hasMany') ||
                            Str::contains($methodContent, '->belongsTo') ||
                            Str::contains($methodContent, '->belongsToMany') ||
                            Str::contains($methodContent, '->morphTo') ||
                            Str::contains($methodContent, '->morphMany')) {
                            // Try to determine relationship type
                            $type = null;
                            if (Str::contains($methodContent, '->hasOne')) {
                                $type = 'hasOne';
                            } elseif (Str::contains($methodContent, '->hasMany')) {
                                $type = 'hasMany';
                            } elseif (Str::contains($methodContent, '->belongsTo')) {
                                $type = 'belongsTo';
                            } elseif (Str::contains($methodContent, '->belongsToMany')) {
                                $type = 'belongsToMany';
                            } elseif (Str::contains($methodContent, '->morphTo')) {
                                $type = 'morphTo';
                            } elseif (Str::contains($methodContent, '->morphMany')) {
                                $type = 'morphMany';
                            }

                            $relationships[$methodName] = [
                                'type' => $type,
                                'method' => $methodName,
                            ];
                        }
                    }

                    // Get fillable attributes
                    $fillable = [];
                    if ($reflectionClass->hasProperty('fillable')) {
                        $property = $reflectionClass->getProperty('fillable');
                        $property->setAccessible(true);
                        $instance = $reflectionClass->newInstanceWithoutConstructor();
                        $fillable = $property->getValue($instance);
                    }

                    $modelName = $reflectionClass->getShortName();
                    $this->models[$modelName] = [
                        'class' => $fullyQualifiedClassName,
                        'relationships' => $relationships,
                        'fillable' => $fillable,
                    ];
                } catch (\Exception) {
                    // Skip problematic models
                    continue;
                }
            }
        }
    }

    /**
     * Collect all Filament resources from the application
     */
    protected function collectFilamentResources()
    {
        $resourcesPath = app_path('Filament/Resources');

        if (! File::isDirectory($resourcesPath)) {
            return;
        }

        $files = File::allFiles($resourcesPath);

        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && ! Str::contains($file->getPathname(), '/Pages/') && ! $this->shouldIgnoreFile($file->getPathname())) {
                $path = $file->getPathname();
                $relativePath = str_replace(app_path() . '/', '', $path);
                $className = str_replace(['.php', '/'], ['', '\\'], $relativePath);
                $fullyQualifiedClassName = 'App\\' . $className;

                if (! class_exists($fullyQualifiedClassName)) {
                    continue;
                }

                try {
                    $reflectionClass = new ReflectionClass($fullyQualifiedClassName);

                    // Skip abstract classes
                    if ($reflectionClass->isAbstract()) {
                        continue;
                    }

                    // Get the model this resource manages
                    $model = null;
                    if ($reflectionClass->hasProperty('model')) {
                        $property = $reflectionClass->getProperty('model');
                        $property->setAccessible(true);
                        $instance = $reflectionClass->newInstanceWithoutConstructor();
                        $model = $property->getValue($instance);
                    }

                    // Get the navigation group
                    $navigationGroup = null;
                    if ($reflectionClass->hasProperty('navigationGroup')) {
                        $property = $reflectionClass->getProperty('navigationGroup');
                        $property->setAccessible(true);
                        $instance = $reflectionClass->newInstanceWithoutConstructor();
                        $navigationGroup = $property->getValue($instance);
                    }

                    // Get the navigation icon
                    $navigationIcon = null;
                    if ($reflectionClass->hasProperty('navigationIcon')) {
                        $property = $reflectionClass->getProperty('navigationIcon');
                        $property->setAccessible(true);
                        $instance = $reflectionClass->newInstanceWithoutConstructor();
                        $navigationIcon = $property->getValue($instance);
                    }

                    $resourceName = $reflectionClass->getShortName();
                    $this->filamentResources[$resourceName] = [
                        'class' => $fullyQualifiedClassName,
                        'model' => $model,
                        'navigationGroup' => $navigationGroup,
                        'navigationIcon' => $navigationIcon,
                    ];
                } catch (\Exception) {
                    // Skip problematic resources
                    continue;
                }
            }
        }
    }

    /**
     * Collect all Livewire components from the application
     */
    protected function collectLivewireComponents()
    {
        $livewirePath = app_path('Livewire');

        if (! File::isDirectory($livewirePath)) {
            return;
        }

        $files = File::allFiles($livewirePath);

        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && ! $this->shouldIgnoreFile($file->getPathname())) {
                $path = $file->getPathname();
                $relativePath = str_replace(app_path() . '/', '', $path);
                $className = str_replace(['.php', '/'], ['', '\\'], $relativePath);
                $fullyQualifiedClassName = 'App\\' . $className;

                if (! class_exists($fullyQualifiedClassName)) {
                    continue;
                }

                try {
                    $reflectionClass = new ReflectionClass($fullyQualifiedClassName);

                    // Skip abstract classes
                    if ($reflectionClass->isAbstract()) {
                        continue;
                    }

                    // Find the corresponding view
                    $view = null;
                    if ($reflectionClass->hasProperty('view')) {
                        $property = $reflectionClass->getProperty('view');
                        $property->setAccessible(true);
                        $instance = $reflectionClass->newInstanceWithoutConstructor();
                        $view = $property->getValue($instance);
                    } else {
                        // Try to infer the view name based on component name
                        $componentName = $reflectionClass->getShortName();
                        $componentNamespace = str_replace('App\\Livewire\\', '', $reflectionClass->getName());
                        $componentNamespace = str_replace('\\', '.', $componentNamespace);
                        $componentNamespace = Str::kebab(str_replace($componentName, '', $componentNamespace));
                        $componentName = Str::kebab($componentName);

                        if ($componentNamespace) {
                            $view = 'livewire.' . rtrim($componentNamespace, '.') . '.' . $componentName;
                        } else {
                            $view = 'livewire.' . $componentName;
                        }
                    }

                    $componentName = $reflectionClass->getShortName();
                    $this->livewireComponents[$componentName] = [
                        'class' => $fullyQualifiedClassName,
                        'view' => $view,
                    ];
                } catch (\Exception) {
                    // Skip problematic components
                    continue;
                }
            }
        }
    }

    /**
     * Generate the UI map in the requested format
     */
    protected function generateMap()
    {
        $format = $this->option('format');

        return match ($format) {
            'json' => $this->generateJsonMap(),
            'html' => $this->generateHtmlMap(),
            default => $this->generateMarkdownMap(),
        };
    }

    /**
     * Generate the UI map in Markdown format
     */
    protected function generateMarkdownMap()
    {
        $output = "# NM-DigitalHUB UI Interface Map\n\n";
        $output .= 'Generated on: ' . date('Y-m-d H:i:s') . "\n\n";

        // Routes section
        $output .= "## Routes\n\n";

        // Group routes by type (admin/public)
        $adminRoutes = array_filter($this->routes, fn ($route) => $route['is_admin']);

        $publicRoutes = array_filter($this->routes, fn ($route) => ! $route['is_admin']);

        // Public routes table
        if ($publicRoutes !== []) {
            $output .= "### Public Routes\n\n";
            $output .= "| URI | Methods | Name | Controller | Middleware |\n";
            $output .= "|-----|---------|------|------------|------------|\n";

            foreach ($publicRoutes as $route) {
                $methods = implode(', ', $route['methods']);
                $controller = $route['controller'] ? class_basename($route['controller']) . '@' . $route['method'] : 'N/A';
                $middleware = implode(', ', array_map(fn ($m) => is_string($m) ? $m : 'Closure', $route['middleware']));

                $output .= "| {$route['uri']} | {$methods} | {$route['name']} | {$controller} | {$middleware} |\n";
            }

            $output .= "\n";
        }

        // Admin routes table
        if ($adminRoutes !== []) {
            $output .= "### Admin Routes\n\n";
            $output .= "| URI | Methods | Name | Controller | Middleware |\n";
            $output .= "|-----|---------|------|------------|------------|\n";

            foreach ($adminRoutes as $route) {
                $methods = implode(', ', $route['methods']);
                $controller = $route['controller'] ? class_basename($route['controller']) . '@' . $route['method'] : 'N/A';
                $middleware = implode(', ', array_map(fn ($m) => is_string($m) ? $m : 'Closure', $route['middleware']));

                $output .= "| {$route['uri']} | {$methods} | {$route['name']} | {$controller} | {$middleware} |\n";
            }

            $output .= "\n";
        }

        // Views section
        if (! empty($this->views)) {
            $output .= "## Views\n\n";
            $output .= "| View Name | Path | Title | Extends | Components |\n";
            $output .= "|-----------|------|-------|---------|------------|\n";

            foreach ($this->views as $viewName => $view) {
                $title = $view['title'] ?? 'N/A';
                $extends = $view['extends'] ?? 'N/A';
                $components = implode(', ', $view['components']);

                $output .= "| {$viewName} | {$view['path']} | {$title} | {$extends} | {$components} |\n";
            }

            $output .= "\n";
        }

        // Models section
        if (! empty($this->models)) {
            $output .= "## Models\n\n";
            $output .= "| Model | Class | Relationships |\n";
            $output .= "|-------|-------|---------------|\n";

            foreach ($this->models as $modelName => $model) {
                $relationshipsList = [];
                foreach ($model['relationships'] as $name => $relationship) {
                    $relationshipsList[] = "{$name} ({$relationship['type']})";
                }
                $relationships = implode(', ', $relationshipsList);

                $output .= "| {$modelName} | {$model['class']} | {$relationships} |\n";
            }

            $output .= "\n";
        }

        // Filament resources section
        if (! empty($this->filamentResources)) {
            $output .= "## Filament Resources\n\n";
            $output .= "| Resource | Model | Navigation Group | Icon |\n";
            $output .= "|----------|-------|------------------|------|\n";

            foreach ($this->filamentResources as $resourceName => $resource) {
                $model = $resource['model'] ? class_basename($resource['model']) : 'N/A';
                $navigationGroup = $resource['navigationGroup'] ?? 'N/A';
                $navigationIcon = $resource['navigationIcon'] ?? 'N/A';

                $output .= "| {$resourceName} | {$model} | {$navigationGroup} | {$navigationIcon} |\n";
            }

            $output .= "\n";
        }

        // Livewire components section
        if (! empty($this->livewireComponents)) {
            $output .= "## Livewire Components\n\n";
            $output .= "| Component | Class | View |\n";
            $output .= "|-----------|-------|------|\n";

            foreach ($this->livewireComponents as $componentName => $component) {
                $view = $component['view'] ?? 'N/A';

                $output .= "| {$componentName} | {$component['class']} | {$view} |\n";
            }

            $output .= "\n";
        }

        // Add recommendations if enabled
        if ($this->option('add-recommendations')) {
            $output .= "## Recommendations\n\n";

            // Missing View Components
            $output .= "### Missing View Components\n\n";
            $output .= "The following components are referenced in views but may not exist:\n\n";

            $missingComponents = [];
            foreach ($this->views as $viewName => $view) {
                foreach ($view['components'] as $component) {
                    // Check if component exists as a view
                    $componentView = str_replace('-', '.', $component);
                    $componentViewPath = "components.{$componentView}";

                    if (! isset($this->views[$componentViewPath]) && ! in_array($component, $missingComponents)) {
                        $missingComponents[] = $component;
                    }
                }
            }

            if ($missingComponents === []) {
                $output .= "No missing components detected.\n\n";
            } else {
                $output .= '- ' . implode("\n- ", $missingComponents) . "\n\n";
            }

            // Unused Models
            $output .= "### Unused Models\n\n";
            $output .= "The following models do not have corresponding Filament resources:\n\n";

            $unusedModels = [];
            foreach ($this->models as $modelName => $model) {
                $hasResource = false;
                foreach ($this->filamentResources as $resource) {
                    if (isset($resource['model']) && class_basename($resource['model']) === $modelName) {
                        $hasResource = true;
                        break;
                    }
                }

                if (! $hasResource) {
                    $unusedModels[] = $modelName;
                }
            }

            if ($unusedModels === []) {
                $output .= "No unused models detected.\n\n";
            } else {
                $output .= '- ' . implode("\n- ", $unusedModels) . "\n\n";
            }

            // Potentially Unused Views
            $output .= "### Potentially Unused Views\n\n";
            $output .= "The following views may not be directly referenced by routes or other views:\n\n";

            $referencedViews = [];

            // Views referenced by routes (through controllers)

            // Views referenced by other views (extends or includes)
            foreach ($this->views as $viewName => $view) {
                if ($view['extends']) {
                    $referencedViews[$view['extends']] = true;
                }

                foreach ($view['includes'] as $included) {
                    $referencedViews[$included] = true;
                }
            }

            // Views referenced by Livewire components
            foreach ($this->livewireComponents as $component) {
                if ($component['view']) {
                    $referencedViews[$component['view']] = true;
                }
            }

            $unusedViews = [];
            foreach ($this->views as $viewName => $view) {
                if (! isset($referencedViews[$viewName]) && ! Str::startsWith($viewName, 'components.')) {
                    $unusedViews[] = $viewName;
                }
            }

            if ($unusedViews === []) {
                $output .= "No potentially unused views detected.\n\n";
            } else {
                $output .= '- ' . implode("\n- ", $unusedViews) . "\n\n";
            }

            // Views without Titles
            $output .= "### Views Without Titles\n\n";
            $output .= "The following views do not have explicit title tags or section declarations:\n\n";

            $viewsWithoutTitles = [];
            foreach ($this->views as $viewName => $view) {
                if (empty($view['title']) &&
                    ! Str::startsWith($viewName, 'components.') &&
                    ! Str::startsWith($viewName, 'layouts.') &&
                    ! Str::startsWith($viewName, 'partials.')) {
                    $viewsWithoutTitles[] = $viewName;
                }
            }

            if ($viewsWithoutTitles === []) {
                $output .= "No views without titles detected.\n\n";
            } else {
                $output .= '- ' . implode("\n- ", $viewsWithoutTitles) . "\n\n";
            }

            // Routes without Names
            $output .= "### Routes Without Names\n\n";
            $output .= "The following routes do not have explicit names, which may make URL generation more difficult:\n\n";

            $routesWithoutNames = [];
            foreach ($this->routes as $route) {
                if (empty($route['name'])) {
                    $routesWithoutNames[] = $route['uri'] . ' (' . implode(', ', $route['methods']) . ')';
                }
            }

            if ($routesWithoutNames === []) {
                $output .= "No routes without names detected.\n\n";
            } else {
                $output .= '- ' . implode("\n- ", $routesWithoutNames) . "\n\n";
            }

            // Structure Recommendations
            $output .= "### Structure Recommendations\n\n";

            $recommendations = [];

            // Check if there are too many routes
            if (count($this->routes) > 50) {
                $recommendations[] = 'Consider organizing routes into smaller, more focused groups';
            }

            // Check if there are too many models without relationships
            $modelsWithoutRelationships = 0;
            foreach ($this->models as $model) {
                if (empty($model['relationships'])) {
                    $modelsWithoutRelationships++;
                }
            }

            if ($modelsWithoutRelationships > 3) {
                $recommendations[] = "Several models ({$modelsWithoutRelationships}) lack defined relationships. Consider adding relationships for better data modeling";
            }

            // Check for potential controller complexity
            $controllerMethodCounts = [];
            foreach ($this->routes as $route) {
                if ($route['controller']) {
                    $controllerName = $route['controller'];
                    if (! isset($controllerMethodCounts[$controllerName])) {
                        $controllerMethodCounts[$controllerName] = 0;
                    }
                    $controllerMethodCounts[$controllerName]++;
                }
            }

            foreach ($controllerMethodCounts as $controller => $count) {
                if ($count > 10) {
                    $recommendations[] = "Controller '{$controller}' has {$count} routes. Consider breaking it into smaller, more focused controllers";
                }
            }

            if ($recommendations === []) {
                $output .= "No structure recommendations at this time.\n\n";
            } else {
                $output .= '- ' . implode("\n- ", $recommendations) . "\n\n";
            }
        }

        // Add cross-relation table if enabled
        if ($this->option('generate-cross-relation-table')) {
            $output .= "## Cross-Relation Table\n\n";
            $output .= "This table shows connections between different components of the application.\n\n";

            // Models to Resources table
            $output .= "### Models to Resources\n\n";
            $output .= "| Model | Resource | Navigation Group |\n";
            $output .= "|-------|----------|------------------|\n";

            $modelResourceMappings = [];

            foreach ($this->models as $modelName => $model) {
                $resources = [];

                foreach ($this->filamentResources as $resourceName => $resource) {
                    if (isset($resource['model']) && class_basename($resource['model']) === $modelName) {
                        $resources[] = [
                            'name' => $resourceName,
                            'group' => $resource['navigationGroup'] ?? 'N/A',
                        ];
                    }
                }

                if ($resources === []) {
                    $output .= "| {$modelName} | None | N/A |\n";
                } else {
                    foreach ($resources as $index => $resource) {
                        if ($index === 0) {
                            $output .= "| {$modelName} | {$resource['name']} | {$resource['group']} |\n";
                        } else {
                            $output .= "| | {$resource['name']} | {$resource['group']} |\n";
                        }
                    }
                }
            }

            $output .= "\n";

            // Routes to Controllers table
            $output .= "### Routes to Controllers\n\n";
            $output .= "| Route | HTTP Methods | Controller | Method |\n";
            $output .= "|-------|--------------|------------|--------|\n";

            $controllerRouteMappings = [];

            foreach ($this->routes as $route) {
                $controller = $route['controller'] ? class_basename($route['controller']) : 'N/A';
                $method = $route['method'] ?? 'N/A';
                $methods = implode(', ', $route['methods']);

                $output .= "| {$route['uri']} | {$methods} | {$controller} | {$method} |\n";
            }

            $output .= "\n";

            // Livewire Components to Views table
            $output .= "### Livewire Components to Views\n\n";
            $output .= "| Component | View | Used in Routes |\n";
            $output .= "|-----------|------|----------------|\n";

            foreach ($this->livewireComponents as $componentName => $component) {
                $view = $component['view'] ?? 'N/A';

                // Find routes that use this component
                $relatedRoutes = [];
                foreach ($this->routes as $route) {
                    if ($route['controller'] === $component['class']) {
                        $relatedRoutes[] = $route['uri'];
                    }
                }

                $routesList = $relatedRoutes === [] ? 'None' : implode(', ', $relatedRoutes);

                $output .= "| {$componentName} | {$view} | {$routesList} |\n";
            }

            $output .= "\n";
        }

        return $output;
    }

    /**
     * Generate the UI map in JSON format
     */
    protected function generateJsonMap()
    {
        $map = [
            'meta' => [
                'generated_at' => date('Y-m-d H:i:s'),
            ],
            'routes' => $this->routes,
            'views' => $this->views,
            'models' => $this->models,
            'filament_resources' => $this->filamentResources,
            'livewire_components' => $this->livewireComponents,
        ];

        return json_encode($map, JSON_PRETTY_PRINT);
    }

    /**
     * Generate the UI map in HTML format
     */
    protected function generateHtmlMap()
    {
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NM-DigitalHUB UI Interface Map</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1, h2, h3 {
            color: #2c3e50;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>NM-DigitalHUB UI Interface Map</h1>
    <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>';

        // Routes section
        $html .= '<h2>Routes</h2>';

        // Group routes by type (admin/public)
        $adminRoutes = array_filter($this->routes, fn ($route) => $route['is_admin']);

        $publicRoutes = array_filter($this->routes, fn ($route) => ! $route['is_admin']);

        // Public routes table
        if ($publicRoutes !== []) {
            $html .= '<h3>Public Routes</h3>';
            $html .= '<table>
                <tr>
                    <th>URI</th>
                    <th>Methods</th>
                    <th>Name</th>
                    <th>Controller</th>
                    <th>Middleware</th>
                </tr>';

            foreach ($publicRoutes as $route) {
                $methods = implode(', ', $route['methods']);
                $controller = $route['controller'] ? class_basename($route['controller']) . '@' . $route['method'] : 'N/A';
                $middleware = implode(', ', array_map(fn ($m) => is_string($m) ? $m : 'Closure', $route['middleware']));

                $html .= "<tr>
                    <td>{$route['uri']}</td>
                    <td>{$methods}</td>
                    <td>{$route['name']}</td>
                    <td>{$controller}</td>
                    <td>{$middleware}</td>
                </tr>";
            }

            $html .= '</table>';
        }

        // Admin routes table
        if ($adminRoutes !== []) {
            $html .= '<h3>Admin Routes</h3>';
            $html .= '<table>
                <tr>
                    <th>URI</th>
                    <th>Methods</th>
                    <th>Name</th>
                    <th>Controller</th>
                    <th>Middleware</th>
                </tr>';

            foreach ($adminRoutes as $route) {
                $methods = implode(', ', $route['methods']);
                $controller = $route['controller'] ? class_basename($route['controller']) . '@' . $route['method'] : 'N/A';
                $middleware = implode(', ', array_map(fn ($m) => is_string($m) ? $m : 'Closure', $route['middleware']));

                $html .= "<tr>
                    <td>{$route['uri']}</td>
                    <td>{$methods}</td>
                    <td>{$route['name']}</td>
                    <td>{$controller}</td>
                    <td>{$middleware}</td>
                </tr>";
            }

            $html .= '</table>';
        }

        // Views section
        if (! empty($this->views)) {
            $html .= '<h2>Views</h2>';
            $html .= '<table>
                <tr>
                    <th>View Name</th>
                    <th>Path</th>
                    <th>Title</th>
                    <th>Extends</th>
                    <th>Components</th>
                </tr>';

            foreach ($this->views as $viewName => $view) {
                $title = $view['title'] ?? 'N/A';
                $extends = $view['extends'] ?? 'N/A';
                $components = implode(', ', $view['components']);

                $html .= "<tr>
                    <td>{$viewName}</td>
                    <td>{$view['path']}</td>
                    <td>{$title}</td>
                    <td>{$extends}</td>
                    <td>{$components}</td>
                </tr>";
            }

            $html .= '</table>';
        }

        // Models section
        if (! empty($this->models)) {
            $html .= '<h2>Models</h2>';
            $html .= '<table>
                <tr>
                    <th>Model</th>
                    <th>Class</th>
                    <th>Relationships</th>
                </tr>';

            foreach ($this->models as $modelName => $model) {
                $relationshipsList = [];
                foreach ($model['relationships'] as $name => $relationship) {
                    $relationshipsList[] = "{$name} ({$relationship['type']})";
                }
                $relationships = implode(', ', $relationshipsList);

                $html .= "<tr>
                    <td>{$modelName}</td>
                    <td>{$model['class']}</td>
                    <td>{$relationships}</td>
                </tr>";
            }

            $html .= '</table>';
        }

        // Filament resources section
        if (! empty($this->filamentResources)) {
            $html .= '<h2>Filament Resources</h2>';
            $html .= '<table>
                <tr>
                    <th>Resource</th>
                    <th>Model</th>
                    <th>Navigation Group</th>
                    <th>Icon</th>
                </tr>';

            foreach ($this->filamentResources as $resourceName => $resource) {
                $model = $resource['model'] ? class_basename($resource['model']) : 'N/A';
                $navigationGroup = $resource['navigationGroup'] ?? 'N/A';
                $navigationIcon = $resource['navigationIcon'] ?? 'N/A';

                $html .= "<tr>
                    <td>{$resourceName}</td>
                    <td>{$model}</td>
                    <td>{$navigationGroup}</td>
                    <td>{$navigationIcon}</td>
                </tr>";
            }

            $html .= '</table>';
        }

        // Livewire components section
        if (! empty($this->livewireComponents)) {
            $html .= '<h2>Livewire Components</h2>';
            $html .= '<table>
                <tr>
                    <th>Component</th>
                    <th>Class</th>
                    <th>View</th>
                </tr>';

            foreach ($this->livewireComponents as $componentName => $component) {
                $view = $component['view'] ?? 'N/A';

                $html .= "<tr>
                    <td>{$componentName}</td>
                    <td>{$component['class']}</td>
                    <td>{$view}</td>
                </tr>";
            }

            $html .= '</table>';
        }

        // Close HTML
        $html .= '</body></html>';

        return $html;
    }

    /**
     * Deduplicate entries in all collections
     */
    protected function deduplicateEntries()
    {
        // Deduplicate routes by URI
        $uniqueRoutes = [];
        $routeKeys = [];

        foreach ($this->routes as $route) {
            $key = $route['uri'] . '|' . implode(',', $route['methods']);
            if (! isset($routeKeys[$key])) {
                $routeKeys[$key] = true;
                $uniqueRoutes[] = $route;
            }
        }

        $this->routes = $uniqueRoutes;

        // Deduplicate views by path
        $uniqueViews = [];

        foreach ($this->views as $name => $view) {
            $uniqueViews[$name] = $view;
        }

        $this->views = $uniqueViews;

        // Deduplicate models by class
        $uniqueModels = [];

        foreach ($this->models as $name => $model) {
            $uniqueModels[$name] = $model;
        }

        $this->models = $uniqueModels;

        // Deduplicate Filament resources by class
        $uniqueResources = [];

        foreach ($this->filamentResources as $name => $resource) {
            $uniqueResources[$name] = $resource;
        }

        $this->filamentResources = $uniqueResources;

        // Deduplicate Livewire components by class
        $uniqueComponents = [];

        foreach ($this->livewireComponents as $name => $component) {
            $uniqueComponents[$name] = $component;
        }

        $this->livewireComponents = $uniqueComponents;
    }

    /**
     * Generate relations JSON for cross-reference
     */
    protected function generateRelationsJson()
    {
        $relations = [
            'meta' => [
                'generated_at' => date('Y-m-d H:i:s'),
                'format_version' => '1.0',
            ],
            'entities' => [],
            'relationships' => [],
        ];

        // Add routes as entities
        foreach ($this->routes as $index => $route) {
            $entityId = 'route_' . $index;
            $relations['entities'][$entityId] = [
                'type' => 'route',
                'name' => $route['name'] ?? $route['uri'],
                'uri' => $route['uri'],
                'methods' => $route['methods'],
                'is_admin' => $route['is_admin'],
            ];

            // Link routes to controllers
            if ($route['controller']) {
                $controllerId = 'controller_' . md5((string) $route['controller']);

                if (! isset($relations['entities'][$controllerId])) {
                    $relations['entities'][$controllerId] = [
                        'type' => 'controller',
                        'name' => class_basename($route['controller']),
                        'class' => $route['controller'],
                    ];
                }

                $relations['relationships'][] = [
                    'source' => $entityId,
                    'target' => $controllerId,
                    'type' => 'invokes',
                    'method' => $route['method'],
                ];
            }
        }

        // Add views as entities
        foreach ($this->views as $name => $view) {
            $entityId = 'view_' . md5((string) $name);
            $relations['entities'][$entityId] = [
                'type' => 'view',
                'name' => $name,
                'path' => $view['path'],
                'title' => $view['title'] ?? '',
            ];

            // Link views to their parent views (extends)
            if ($view['extends']) {
                $parentId = 'view_' . md5((string) $view['extends']);

                if (! isset($relations['entities'][$parentId])) {
                    $relations['entities'][$parentId] = [
                        'type' => 'view',
                        'name' => $view['extends'],
                        'path' => '',
                        'title' => '',
                    ];
                }

                $relations['relationships'][] = [
                    'source' => $entityId,
                    'target' => $parentId,
                    'type' => 'extends',
                ];
            }

            // Link views to included views
            foreach ($view['includes'] as $included) {
                $includedId = 'view_' . md5((string) $included);

                if (! isset($relations['entities'][$includedId])) {
                    $relations['entities'][$includedId] = [
                        'type' => 'view',
                        'name' => $included,
                        'path' => '',
                        'title' => '',
                    ];
                }

                $relations['relationships'][] = [
                    'source' => $entityId,
                    'target' => $includedId,
                    'type' => 'includes',
                ];
            }

            // Link views to components
            foreach ($view['components'] as $component) {
                $componentId = 'component_' . md5((string) $component);

                if (! isset($relations['entities'][$componentId])) {
                    $relations['entities'][$componentId] = [
                        'type' => 'component',
                        'name' => $component,
                    ];
                }

                $relations['relationships'][] = [
                    'source' => $entityId,
                    'target' => $componentId,
                    'type' => 'uses',
                ];
            }
        }

        // Add models as entities
        foreach ($this->models as $name => $model) {
            $entityId = 'model_' . md5((string) $name);
            $relations['entities'][$entityId] = [
                'type' => 'model',
                'name' => $name,
                'class' => $model['class'],
            ];

            // Link models with their relationships
            foreach ($model['relationships'] as $relName => $relationship) {
                $targetModelName = $this->extractModelFromRelationship($relationship);

                if ($targetModelName) {
                    $targetModelId = 'model_' . md5((string) $targetModelName);

                    if (! isset($relations['entities'][$targetModelId])) {
                        $relations['entities'][$targetModelId] = [
                            'type' => 'model',
                            'name' => $targetModelName,
                            'class' => "App\\Models\\{$targetModelName}",
                        ];
                    }

                    $relations['relationships'][] = [
                        'source' => $entityId,
                        'target' => $targetModelId,
                        'type' => $relationship['type'],
                        'name' => $relName,
                    ];
                }
            }
        }

        // Add Filament resources as entities
        foreach ($this->filamentResources as $name => $resource) {
            $entityId = 'resource_' . md5((string) $name);
            $relations['entities'][$entityId] = [
                'type' => 'filament_resource',
                'name' => $name,
                'class' => $resource['class'],
                'navigation_group' => $resource['navigationGroup'] ?? '',
            ];

            // Link resources to their models
            if ($resource['model']) {
                $modelName = class_basename($resource['model']);
                $modelId = 'model_' . md5($modelName);

                if (! isset($relations['entities'][$modelId])) {
                    $relations['entities'][$modelId] = [
                        'type' => 'model',
                        'name' => $modelName,
                        'class' => $resource['model'],
                    ];
                }

                $relations['relationships'][] = [
                    'source' => $entityId,
                    'target' => $modelId,
                    'type' => 'manages',
                ];
            }
        }

        // Add Livewire components as entities
        foreach ($this->livewireComponents as $name => $component) {
            $entityId = 'livewire_' . md5((string) $name);
            $relations['entities'][$entityId] = [
                'type' => 'livewire_component',
                'name' => $name,
                'class' => $component['class'],
            ];

            // Link Livewire components to their views
            if ($component['view']) {
                $viewId = 'view_' . md5((string) $component['view']);

                if (! isset($relations['entities'][$viewId])) {
                    $relations['entities'][$viewId] = [
                        'type' => 'view',
                        'name' => $component['view'],
                        'path' => '',
                        'title' => '',
                    ];
                }

                $relations['relationships'][] = [
                    'source' => $entityId,
                    'target' => $viewId,
                    'type' => 'renders',
                ];
            }
        }

        return json_encode($relations, JSON_PRETTY_PRINT);
    }

    /**
     * Extract model name from a relationship definition
     */
    protected function extractModelFromRelationship($relationship)
    {
        // This is a simplified extraction that assumes the relationship
        // points to a model in the same namespace. A more robust implementation
        // would parse the actual code.
        return null; // Placeholder, would be implemented with actual code analysis
    }

    /**
     * Check if a file should be ignored based on the ignore patterns
     */
    protected function shouldIgnoreFile($path)
    {
        if (empty($this->ignorePatterns)) {
            return false;
        }

        foreach ($this->ignorePatterns as $pattern) {
            if (Str::is($pattern, basename((string) $path))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate a visual diagram in SVG format
     */
    protected function generateVisualDiagram()
    {
        $this->option('graph-style');

        // Setup SVG document
        $width = 1200;
        $height = 900;
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}">
    <defs>
        <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
            <polygon points="0 0, 10 3.5, 0 7" fill="#666" />
        </marker>
        <marker id="dotted-arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
            <polygon points="0 0, 10 3.5, 0 7" fill="#999" />
        </marker>
    </defs>
    <style>
        .node { font-family: Arial, sans-serif; font-size: 12px; }
        .node-route { fill: #e1f5fe; stroke: #4fc3f7; stroke-width: 1; }
        .node-controller { fill: #e8f5e9; stroke: #66bb6a; stroke-width: 1; }
        .node-view { fill: #fff3e0; stroke: #ffb74d; stroke-width: 1; }
        .node-model { fill: #f3e5f5; stroke: #ba68c8; stroke-width: 1; }
        .node-resource { fill: #e3f2fd; stroke: #42a5f5; stroke-width: 1; }
        .node-livewire { fill: #fce4ec; stroke: #f06292; stroke-width: 1; }
        .node-admin { fill: #ede7f6; stroke: #9575cd; stroke-width: 1; }
        .node-text { font-size: 10px; fill: #333; }
        .link { stroke: #666; stroke-width: 1; fill: none; }
        .link-dotted { stroke: #999; stroke-width: 1; stroke-dasharray: 3,3; fill: none; }
        .label { font-size: 8px; fill: #666; }
        .group-box { fill-opacity: 0.1; stroke-width: 1; }
        .group-label { font-size: 14px; fill: #333; font-weight: bold; }
    </style>

SVG;

        // In a full implementation, we would:
        // 1. Calculate node positions based on the selected layout style
        // 2. Draw nodes for each entity type (routes, controllers, views, etc.)
        // 3. Draw connections between related entities
        // 4. Add groups for public/admin sections

        // For this example, we'll add a placeholder diagram with a sample layout
        $svg .= <<<SVG
    <!-- Background group boxes -->
    <rect class="group-box" fill="#e3f2fd" x="50" y="50" width="500" height="300" rx="5" ry="5" />
    <text class="group-label" x="60" y="70">Public Section</text>

    <rect class="group-box" fill="#ede7f6" x="600" y="50" width="500" height="300" rx="5" ry="5" />
    <text class="group-label" x="610" y="70">Admin Section</text>

    <rect class="group-box" fill="#e8f5e9" x="50" y="400" width="1050" height="200" rx="5" ry="5" />
    <text class="group-label" x="60" y="420">Models &amp; Resources</text>

    <!-- Sample nodes -->
    <rect class="node node-route" x="100" y="100" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="110" y="125">/ (home)</text>

    <rect class="node node-controller" x="300" y="100" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="310" y="125">HomeController</text>

    <rect class="node node-view" x="300" y="200" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="310" y="225">home.blade.php</text>

    <rect class="node node-route node-admin" x="650" y="100" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="660" y="125">/admin/dashboard</text>

    <rect class="node node-livewire" x="850" y="100" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="860" y="125">Admin\Dashboard</text>

    <rect class="node node-view" x="850" y="200" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="860" y="225">admin.dashboard</text>

    <rect class="node node-model" x="100" y="450" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="110" y="475">User</text>

    <rect class="node node-model" x="300" y="450" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="310" y="475">Generator</text>

    <rect class="node node-resource" x="500" y="450" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="510" y="475">GeneratorResource</text>

    <rect class="node node-model" x="700" y="450" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="710" y="475">Product</text>

    <rect class="node node-resource" x="900" y="450" width="120" height="40" rx="5" ry="5" />
    <text class="node-text" x="910" y="475">ProductResource</text>

    <!-- Sample connections -->
    <path class="link" d="M220,120 L300,120" marker-end="url(#arrowhead)" />
    <path class="link" d="M360,140 L360,200" marker-end="url(#arrowhead)" />
    <path class="link" d="M770,120 L850,120" marker-end="url(#arrowhead)" />
    <path class="link" d="M910,140 L910,200" marker-end="url(#arrowhead)" />
    <path class="link-dotted" d="M160,450 L160,300" marker-end="url(#dotted-arrowhead)" />
    <path class="link" d="M420,450 L500,450" marker-end="url(#arrowhead)" />
    <path class="link" d="M820,450 L900,450" marker-end="url(#arrowhead)" />

    <!-- Legend -->
    <rect x="50" y="650" width="1050" height="100" fill="#f5f5f5" rx="5" ry="5" />
    <text x="60" y="670" font-size="14" font-weight="bold">Legend</text>

    <rect class="node-route" x="60" y="690" width="80" height="20" rx="3" ry="3" />
    <text class="node-text" x="100" y="705" text-anchor="middle">Route</text>

    <rect class="node-controller" x="160" y="690" width="80" height="20" rx="3" ry="3" />
    <text class="node-text" x="200" y="705" text-anchor="middle">Controller</text>

    <rect class="node-view" x="260" y="690" width="80" height="20" rx="3" ry="3" />
    <text class="node-text" x="300" y="705" text-anchor="middle">View</text>

    <rect class="node-model" x="360" y="690" width="80" height="20" rx="3" ry="3" />
    <text class="node-text" x="400" y="705" text-anchor="middle">Model</text>

    <rect class="node-resource" x="460" y="690" width="80" height="20" rx="3" ry="3" />
    <text class="node-text" x="500" y="705" text-anchor="middle">Resource</text>

    <rect class="node-livewire" x="560" y="690" width="80" height="20" rx="3" ry="3" />
    <text class="node-text" x="600" y="705" text-anchor="middle">Livewire</text>

    <line class="link" x1="660" y1="700" x2="720" y2="700" marker-end="url(#arrowhead)" />
    <text class="node-text" x="690" y="690" text-anchor="middle">Direct</text>

    <line class="link-dotted" x1="740" y1="700" x2="800" y2="700" marker-end="url(#dotted-arrowhead)" />
    <text class="node-text" x="770" y="690" text-anchor="middle">Reference</text>
</svg>
SVG;

        return $svg;
    }
}
