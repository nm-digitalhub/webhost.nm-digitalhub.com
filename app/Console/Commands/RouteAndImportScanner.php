<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class RouteAndImportScanner extends Command
{
    protected $signature = 'project:scan-routes-imports
                            {--fix : Automatically fix issues}
                            {--report : Generate detailed report}';

    protected $description = 'Scan project files to validate and correct use statements and route definitions';

    protected $issues = [];
    protected $fixes = [];

    public function handle()
    {
        $this->info('=== NM-DigitalHUB Route and Import Scanner ===');

        // Scan routes files
        $this->scanRouteFiles();

        // Scan controllers, middleware, and models for use statements
        $this->scanAppDirectories();

        // Scan views for Livewire components
        $this->scanViewsForLivewireComponents();

        // Generate report
        $this->generateReport();

        // Fix issues if requested
        if ($this->option('fix')) {
            $this->fixIssues();
        }

        return 0;
    }

    private function scanRouteFiles()
    {
        $this->info('Scanning route files...');

        $routeFiles = File::files(base_path('routes'));

        foreach ($routeFiles as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $content = File::get($file->getPathname());
            $routeFileName = $file->getFilename();

            $this->info("Analyzing {$routeFileName}...");

            // Check for missing use statements in route files
            $this->checkMissingUseStatements($content, $routeFileName);

            // Check for duplicate routes
            $this->checkDuplicateRoutes($content, $routeFileName);

            // Check for route naming standards
            $this->checkRouteNamingStandards($content, $routeFileName);

            // Check for middleware usage
            $this->checkMiddlewareUsage($content, $routeFileName);
        }
    }

    private function scanAppDirectories()
    {
        $this->info('Scanning app directories for proper use statements...');

        $directories = [
            'Controllers' => app_path('Http/Controllers'),
            'Middleware' => app_path('Http/Middleware'),
            'Models' => app_path('Models'),
            'Livewire' => app_path('Livewire')
        ];

        foreach ($directories as $type => $directory) {
            if (!File::isDirectory($directory)) {
                $this->warn("Directory not found: {$directory}");
                continue;
            }

            $finder = new Finder();
            $finder->files()->in($directory)->name('*.php');

            foreach ($finder as $file) {
                $content = $file->getContents();
                $relativePath = Str::replaceFirst(app_path(), 'app', $file->getRealPath());

                // Check for namespace consistency
                $this->checkNamespaceConsistency($content, $relativePath, $type);

                // Check for unused imports
                $this->checkUnusedImports($content, $relativePath);

                // Check for missing required imports
                $this->checkMissingRequiredImports($content, $relativePath, $type);
            }
        }
    }

    private function scanViewsForLivewireComponents()
    {
        $this->info('Scanning views for Livewire components...');

        $viewsDirectory = resource_path('views/livewire');

        if (!File::isDirectory($viewsDirectory)) {
            $this->warn("Livewire views directory not found: {$viewsDirectory}");
            return;
        }

        $finder = new Finder();
        $finder->files()->in($viewsDirectory)->name('*.blade.php');

        foreach ($finder as $file) {
            $content = $file->getContents();
            $relativePath = Str::replaceFirst(resource_path(), 'resources', $file->getRealPath());

            // Check for Livewire component references
            $this->checkLivewireComponentReferences($content, $relativePath);
        }
    }

    private function checkMissingUseStatements($content, $fileName)
    {
        // Check for controller references without use statements
        preg_match_all('/\[([^:,\]]+)::class/', $content, $controllerMatches);

        if (isset($controllerMatches[1]) && count($controllerMatches[1]) > 0) {
            foreach ($controllerMatches[1] as $controller) {
                if (!Str::contains($content, "use App\\Http\\Controllers\\{$controller};") &&
                    !Str::contains($content, "use App\\Http\\Controllers\\Admin\\{$controller};") &&
                    !Str::contains($content, "use App\\Http\\Controllers\\Client\\{$controller};") &&
                    !Str::contains($content, "use App\\Http\\Controllers\\Api\\{$controller};") &&
                    !Str::contains($content, "use App\\Http\\Controllers\\Auth\\{$controller};")) {

                    $this->addIssue(
                        'missing_use_statement',
                        "routes/{$fileName}",
                        "Missing use statement for controller [{$controller}]",
                        "Add: use App\\Http\\Controllers\\{$controller}; or appropriate namespace"
                    );
                }
            }
        }

        // Check for Livewire component references without use statements
        preg_match_all('/(Route::get\([^,]+,\s*)([A-Za-z0-9_\\\\]+)::class/', $content, $livewireMatches);

        if (isset($livewireMatches[2]) && count($livewireMatches[2]) > 0) {
            foreach ($livewireMatches[2] as $component) {
                if (!Str::contains($component, '\\') && !Str::contains($content, "use App\\Livewire\\{$component};")) {
                    $this->addIssue(
                        'missing_use_statement',
                        "routes/{$fileName}",
                        "Missing use statement for Livewire component [{$component}]",
                        "Add: use App\\Livewire\\{$component};"
                    );
                }
            }
        }

        // Check for middleware references without use statements
        preg_match_all('/->middleware\(\[?([\'"][^\'",]+[\'"]|[a-zA-Z0-9_:]+)/', $content, $middlewareMatches);

        if (isset($middlewareMatches[1]) && count($middlewareMatches[1]) > 0) {
            foreach ($middlewareMatches[1] as $middleware) {
                $middleware = trim($middleware, '\'"');

                // Skip built-in middleware
                if (in_array($middleware, ['web', 'api', 'auth', 'guest', 'verified'])) {
                    continue;
                }

                // For class-based middleware
                if (Str::contains($middleware, ':')) {
                    $middleware = explode(':', $middleware)[0];
                }

                if (!Str::contains($content, "use App\\Http\\Middleware\\{$middleware};")) {
                    $this->addIssue(
                        'missing_use_statement',
                        "routes/{$fileName}",
                        "Missing use statement for middleware [{$middleware}]",
                        "Add: use App\\Http\\Middleware\\{$middleware};"
                    );
                }
            }
        }
    }

    private function checkDuplicateRoutes($content, $fileName)
    {
        $routes = [];

        // Extract all route definitions
        preg_match_all('/Route::(get|post|put|patch|delete|options|any)\([\'"]([^\'"]+)[\'"]/', $content, $routeMatches, PREG_SET_ORDER);

        foreach ($routeMatches as $match) {
            $method = $match[1];
            $uri = $match[2];
            $routeKey = "{$method}:{$uri}";

            if (isset($routes[$routeKey])) {
                $this->addIssue(
                    'duplicate_route',
                    "routes/{$fileName}",
                    "Duplicate route definition: {$method} '{$uri}'",
                    "Remove or rename one of the duplicate route definitions"
                );
            } else {
                $routes[$routeKey] = true;
            }
        }
    }

    private function checkRouteNamingStandards($content, $fileName)
    {
        // Extract all named routes
        preg_match_all('/->name\([\'"]([^\'"]+)[\'"]/', $content, $nameMatches);

        if (isset($nameMatches[1]) && count($nameMatches[1]) > 0) {
            foreach ($nameMatches[1] as $routeName) {
                // Check for proper namespacing (admin. or client. prefix for respective areas)
                if (Str::contains($fileName, ['admin', 'Admin']) && !Str::startsWith($routeName, 'admin.')) {
                    $this->addIssue(
                        'route_naming',
                        "routes/{$fileName}",
                        "Route name [{$routeName}] in admin section should use 'admin.' prefix",
                        "Rename to: admin.{$routeName}"
                    );
                }

                if (Str::contains($fileName, ['client', 'Client']) && !Str::startsWith($routeName, 'client.')) {
                    $this->addIssue(
                        'route_naming',
                        "routes/{$fileName}",
                        "Route name [{$routeName}] in client section should use 'client.' prefix",
                        "Rename to: client.{$routeName}"
                    );
                }

                // Check for dot notation in route names
                if (!Str::contains($routeName, '.')) {
                    $this->addIssue(
                        'route_naming',
                        "routes/{$fileName}",
                        "Route name [{$routeName}] should use dot notation (e.g., 'resource.action')",
                        "Rename to follow convention: [resource].[action]"
                    );
                }
            }
        }
    }

    private function checkMiddlewareUsage($content, $fileName)
    {
        // Check if auth routes have auth middleware
        if (Str::contains($fileName, 'auth') || preg_match('/Route::middleware\(\[.*?auth.*?\]\)/', $content)) {
            // This is fine, auth routes should have auth middleware
        } else if (
            (Str::contains($fileName, ['admin', 'Admin']) || Str::contains($fileName, ['client', 'Client']))
            && !preg_match('/Route::middleware\(\[.*?auth.*?\]\)/', $content)
        ) {
            $this->addIssue(
                'middleware_usage',
                "routes/{$fileName}",
                "Routes in admin or client sections should be protected by auth middleware",
                "Add auth middleware to route groups in this file"
            );
        }

        // Check for proper admin middleware in admin routes
        if (Str::contains($fileName, ['admin', 'Admin']) && !preg_match('/Route::middleware\(\[.*?IsAdmin.*?\]\)/', $content)) {
            $this->addIssue(
                'middleware_usage',
                "routes/{$fileName}",
                "Admin routes should be protected by IsAdmin middleware",
                "Add IsAdmin middleware to route groups in this file"
            );
        }

        // Check for proper client middleware in client routes
        if (Str::contains($fileName, ['client', 'Client']) && !preg_match('/Route::middleware\(\[.*?IsClient.*?\]\)/', $content)) {
            $this->addIssue(
                'middleware_usage',
                "routes/{$fileName}",
                "Client routes should be protected by IsClient middleware",
                "Add IsClient middleware to route groups in this file"
            );
        }
    }

    private function checkNamespaceConsistency($content, $filePath, $type)
    {
        // Extract namespace
        preg_match('/namespace\s+([^;]+);/', $content, $matches);

        if (!isset($matches[1])) {
            $this->addIssue(
                'missing_namespace',
                $filePath,
                "Missing namespace declaration",
                "Add appropriate namespace based on file location"
            );
            return;
        }

        $namespace = $matches[1];
        $expectedNamespace = $this->determineExpectedNamespace($filePath, $type);

        if ($namespace !== $expectedNamespace) {
            $this->addIssue(
                'namespace_mismatch',
                $filePath,
                "Namespace mismatch: found [{$namespace}], expected [{$expectedNamespace}]",
                "Change namespace to: {$expectedNamespace}"
            );
        }
    }

    private function determineExpectedNamespace($filePath, $type)
    {
        // Extract relative path components
        $parts = explode('/', $filePath);
        array_shift($parts); // Remove 'app'

        // Handle special case for Http folder
        if ($type === 'Controllers' || $type === 'Middleware') {
            // Should start with App\Http
            $namespace = 'App\\Http';

            // Add remaining parts
            foreach ($parts as $part) {
                if (pathinfo($part, PATHINFO_EXTENSION) === 'php') {
                    // Skip file name
                    continue;
                }
                $namespace .= '\\' . $part;
            }

            return $namespace;
        } else {
            // Models and Livewire should start with App
            $namespace = 'App';

            // Add remaining parts
            foreach ($parts as $part) {
                if (pathinfo($part, PATHINFO_EXTENSION) === 'php') {
                    // Skip file name
                    continue;
                }
                $namespace .= '\\' . $part;
            }

            return $namespace;
        }
    }

    private function checkUnusedImports($content, $filePath)
    {
        // Extract all use statements
        preg_match_all('/use\s+([^;]+);/', $content, $useMatches);

        if (!isset($useMatches[1]) || count($useMatches[1]) === 0) {
            return;
        }

        foreach ($useMatches[1] as $import) {
            // Extract the class name from the import
            $parts = explode('\\', $import);
            $className = end($parts);

            // Check for aliased imports
            if (Str::contains($import, ' as ')) {
                list($import, $className) = explode(' as ', $import);
                $className = trim($className);
            }

            // Skip common imports that might be used implicitly
            if (in_array($className, ['Request', 'Response', 'Collection', 'Auth'])) {
                continue;
            }

            // Check if the class name is used in the file
            if (!preg_match('/\b' . preg_quote($className, '/') . '\b(?!\s*;)/', $content)) {
                $this->addIssue(
                    'unused_import',
                    $filePath,
                    "Unused import: {$import}",
                    "Remove: use {$import};"
                );
            }
        }
    }

    private function checkMissingRequiredImports($content, $filePath, $type)
    {
        // Check for required imports based on type
        switch ($type) {
            case 'Controllers':
                // Controllers should extend BaseController or Controller
                if (Str::contains($content, 'extends Controller') && !Str::contains($content, 'use App\Http\Controllers\Controller;')) {
                    $this->addIssue(
                        'missing_required_import',
                        $filePath,
                        "Missing required import for Controller class",
                        "Add: use App\\Http\\Controllers\\Controller;"
                    );
                }
                break;

            case 'Middleware':
                // Middleware should implement Middleware contract
                if (!Str::contains($content, 'use Illuminate\Http\Middleware\TrustProxies;') &&
                    Str::contains($content, 'extends TrustProxies')) {
                    $this->addIssue(
                        'missing_required_import',
                        $filePath,
                        "Missing required import for TrustProxies class",
                        "Add: use Illuminate\\Http\\Middleware\\TrustProxies;"
                    );
                }
                break;

            case 'Models':
                // Models should extend Eloquent Model
                if (Str::contains($content, 'extends Model') && !Str::contains($content, 'use Illuminate\Database\Eloquent\Model;')) {
                    $this->addIssue(
                        'missing_required_import',
                        $filePath,
                        "Missing required import for Model class",
                        "Add: use Illuminate\\Database\\Eloquent\\Model;"
                    );
                }
                break;

            case 'Livewire':
                // Livewire components should extend Component
                if (Str::contains($content, 'extends Component') && !Str::contains($content, 'use Livewire\Component;')) {
                    $this->addIssue(
                        'missing_required_import',
                        $filePath,
                        "Missing required import for Livewire Component class",
                        "Add: use Livewire\\Component;"
                    );
                }
                break;
        }
    }

    private function checkLivewireComponentReferences($content, $filePath)
    {
        // Check for Livewire component references in blade files
        preg_match_all('/<livewire:([^\\s>]+)/', $content, $componentMatches);

        if (isset($componentMatches[1]) && count($componentMatches[1]) > 0) {
            foreach ($componentMatches[1] as $component) {
                // Convert kebab-case to StudlyCase
                $studlyComponent = Str::studly(str_replace(['.', '-'], ['_', '_'], $component));

                // Check if component class exists
                $componentPaths = [
                    app_path("Livewire/{$studlyComponent}.php"),
                    app_path("Livewire/Admin/{$studlyComponent}.php"),
                    app_path("Livewire/Client/{$studlyComponent}.php")
                ];

                $componentExists = false;
                foreach ($componentPaths as $path) {
                    if (File::exists($path)) {
                        $componentExists = true;
                        break;
                    }
                }

                if (!$componentExists) {
                    $this->addIssue(
                        'missing_livewire_component',
                        $filePath,
                        "Livewire component [{$component}] is referenced but doesn't exist",
                        "Create component class at app/Livewire/{$studlyComponent}.php or in appropriate subdirectory"
                    );
                }
            }
        }
    }

    private function addIssue($type, $file, $description, $suggestion)
    {
        $this->issues[] = [
            'type' => $type,
            'file' => $file,
            'description' => $description,
            'suggestion' => $suggestion
        ];

        // Also add to fixes if fixable
        if (in_array($type, ['missing_use_statement', 'unused_import', 'missing_required_import', 'namespace_mismatch'])) {
            $this->fixes[] = [
                'type' => $type,
                'file' => $file,
                'description' => $description,
                'suggestion' => $suggestion
            ];
        }
    }

    private function generateReport()
    {
        if (count($this->issues) === 0) {
            $this->info('No issues found! Everything looks good.');
            return;
        }

        $this->line('');
        $this->line('=== Issues Report ===');

        // Group issues by file
        $issuesByFile = [];
        foreach ($this->issues as $issue) {
            $file = $issue['file'];
            if (!isset($issuesByFile[$file])) {
                $issuesByFile[$file] = [];
            }
            $issuesByFile[$file][] = $issue;
        }

        // Display issues
        foreach ($issuesByFile as $file => $issues) {
            $this->line('');
            $this->line("<fg=yellow>File: {$file}</>");

            foreach ($issues as $issue) {
                $this->line(" - <fg=red>{$issue['description']}</>");
                $this->line("   <fg=green>Suggestion: {$issue['suggestion']}</>");
            }
        }

        $this->line('');
        $this->info('Total issues found: ' . count($this->issues));
        $this->info('Fixable issues: ' . count($this->fixes));

        // Generate detailed report if requested
        if ($this->option('report')) {
            $this->generateDetailedReport();
        }
    }

    private function generateDetailedReport()
    {
        $reportPath = storage_path('logs/route-import-scan-' . date('Y-m-d-His') . '.json');

        $report = [
            'timestamp' => now()->toDateTimeString(),
            'issues' => $this->issues,
            'fixes' => $this->fixes,
            'summary' => [
                'total_issues' => count($this->issues),
                'fixable_issues' => count($this->fixes),
                'issues_by_type' => $this->countIssuesByType()
            ]
        ];

        File::put($reportPath, json_encode($report, JSON_PRETTY_PRINT));
        $this->info("Detailed report generated at: {$reportPath}");
    }

    private function countIssuesByType()
    {
        $counts = [];
        foreach ($this->issues as $issue) {
            $type = $issue['type'];
            if (!isset($counts[$type])) {
                $counts[$type] = 0;
            }
            $counts[$type]++;
        }
        return $counts;
    }

    private function fixIssues()
    {
        if (count($this->fixes) === 0) {
            $this->info('No fixable issues found.');
            return;
        }

        $this->line('');
        $this->line('=== Fixing Issues ===');

        $fixedCount = 0;

        // Group fixes by file
        $fixesByFile = [];
        foreach ($this->fixes as $fix) {
            $file = $fix['file'];
            if (!isset($fixesByFile[$file])) {
                $fixesByFile[$file] = [];
            }
            $fixesByFile[$file][] = $fix;
        }

        foreach ($fixesByFile as $file => $fixes) {
            $filePath = base_path($file);

            if (!File::exists($filePath)) {
                $this->warn("File not found: {$filePath}");
                continue;
            }

            $content = File::get($filePath);
            $originalContent = $content;

            $this->line("<fg=yellow>Fixing issues in: {$file}</>");

            foreach ($fixes as $fix) {
                switch ($fix['type']) {
                    case 'missing_use_statement':
                        // Extract what to add from suggestion
                        preg_match('/Add: (.+)/', $fix['suggestion'], $matches);
                        if (isset($matches[1])) {
                            $useStatement = $matches[1];

                            // Find position to insert (after other use statements or after namespace)
                            if (preg_match('/use [^;]+;/', $content)) {
                                // After last use statement
                                $content = preg_replace('/(use [^;]+;\n)(?!use)/', "$1{$useStatement}\n", $content);
                            } else if (preg_match('/namespace [^;]+;/', $content)) {
                                // After namespace
                                $content = preg_replace('/(namespace [^;]+;\n)/', "$1\n{$useStatement}\n", $content);
                            } else {
                                // At beginning after <?php
                                $content = preg_replace('/<\?php/', "<?php\n\n{$useStatement}", $content);
                            }

                            $this->line(" - Added: {$useStatement}");
                            $fixedCount++;
                        }
                        break;

                    case 'unused_import':
                        // Extract what to remove from suggestion
                        preg_match('/Remove: (.+)/', $fix['suggestion'], $matches);
                        if (isset($matches[1])) {
                            $useStatement = $matches[1];

                            // Remove the use statement
                            $content = str_replace($useStatement . "\n", '', $content);
                            $content = str_replace($useStatement, '', $content);

                            $this->line(" - Removed: {$useStatement}");
                            $fixedCount++;
                        }
                        break;

                    case 'missing_required_import':
                        // Extract what to add from suggestion
                        preg_match('/Add: (.+)/', $fix['suggestion'], $matches);
                        if (isset($matches[1])) {
                            $useStatement = $matches[1];

                            // Find position to insert (after other use statements or after namespace)
                            if (preg_match('/use [^;]+;/', $content)) {
                                // After last use statement
                                $content = preg_replace('/(use [^;]+;\n)(?!use)/', "$1{$useStatement}\n", $content);
                            } else if (preg_match('/namespace [^;]+;/', $content)) {
                                // After namespace
                                $content = preg_replace('/(namespace [^;]+;\n)/', "$1\n{$useStatement}\n", $content);
                            } else {
                                // At beginning after <?php
                                $content = preg_replace('/<\?php/', "<?php\n\n{$useStatement}", $content);
                            }

                            $this->line(" - Added: {$useStatement}");
                            $fixedCount++;
                        }
                        break;

                    case 'namespace_mismatch':
                        // Extract what to change from suggestion
                        preg_match('/Change namespace to: (.+)/', $fix['suggestion'], $matches);
                        if (isset($matches[1])) {
                            $newNamespace = $matches[1];

                            // Replace namespace
                            $content = preg_replace('/namespace [^;]+;/', "namespace {$newNamespace};", $content);

                            $this->line(" - Updated namespace to: {$newNamespace}");
                            $fixedCount++;
                        }
                        break;
                }
            }

            // Save changes if any were made
            if ($content !== $originalContent) {
                // Create backup
                File::put($filePath . '.bak', $originalContent);
                $this->line(" - Created backup: {$file}.bak");

                // Save changes
                File::put($filePath, $content);
                $this->line(" - Saved changes to: {$file}");
            }
        }

        $this->line('');
        $this->info("Fixed {$fixedCount} issues out of " . count($this->fixes) . " fixable issues.");

        if ($fixedCount < count($this->fixes)) {
            $this->warn((count($this->fixes) - $fixedCount) . " issues could not be fixed automatically.");
        }
    }
}
