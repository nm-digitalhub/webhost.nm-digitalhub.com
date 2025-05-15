<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FixLivewireComponents extends Command
{
    protected $signature = 'livewire:fix-components';

    protected $description = 'Fix Livewire components to comply with Laravel 12 and Livewire 3 standards';

    public function handle()
    {
        $this->info('Starting Livewire component fixes...');

        // Fix Admin components
        $this->fixComponentsInDirectory(app_path('Livewire/Admin'));

        // Fix Client components
        $this->fixComponentsInDirectory(app_path('Livewire/Client'));

        $this->info('Livewire component fixes completed successfully!');

        return 0;
    }

    private function fixComponentsInDirectory(string $directory)
    {
        if (! File::isDirectory($directory)) {
            $this->warn("Directory not found: {$directory}");

            return;
        }

        $files = File::files($directory);
        $this->info('Processing ' . count($files) . " files in {$directory}");

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $content = File::get($file->getPathname());
            $originalContent = $content;
            $className = $file->getFilenameWithoutExtension();
            $namespace = 'App\\Livewire\\' . basename($directory);

            // Fix duplicate PHP tags
            $content = preg_replace('/^<\?php\s+<\?php/', '<?php', $content);

            // Check if namespace is correct
            if (! Str::contains($content, "namespace {$namespace};")) {
                // Extract existing namespace
                preg_match('/namespace\s+([^;]+);/', (string) $content, $matches);

                if (isset($matches[1])) {
                    $content = str_replace(
                        "namespace {$matches[1]};",
                        "namespace {$namespace};",
                        $content
                    );
                    $this->info("Fixed namespace in {$file->getFilename()}");
                } else {
                    // If no namespace found, add it after the PHP tag
                    $content = preg_replace(
                        '/^<\?php\s+/s',
                        "<?php\n\nnamespace {$namespace};\n\n",
                        (string) $content
                    );
                    $this->info("Added namespace to {$file->getFilename()}");
                }
            }

            // Ensure Livewire Component is imported
            if (! Str::contains($content, 'use Livewire\Component;')) {
                $content = preg_replace(
                    '/namespace[^;]+;\s+/',
                    "$0\nuse Livewire\Component;\n",
                    (string) $content
                );
                $this->info("Added Component import to {$file->getFilename()}");
            }

            // Ensure WithPagination is imported if pagination is used
            if (Str::contains($content, ['paginate(', 'simplePaginate(', 'cursorPaginate(']) &&
                ! Str::contains($content, 'use Livewire\WithPagination;')) {
                $content = preg_replace(
                    '/namespace[^;]+;\s+/',
                    "$0\nuse Livewire\WithPagination;\n",
                    (string) $content
                );

                // Add the trait if not already present
                if (! Str::contains($content, 'use WithPagination;')) {
                    $content = preg_replace(
                        '/(class\s+' . $className . '\s+extends\s+Component\s*{)/',
                        "$1\n    use WithPagination;\n",
                        (string) $content
                    );
                }

                // Add pagination theme if not already present
                if (! Str::contains($content, 'protected $paginationTheme')) {
                    $content = preg_replace(
                        '/(class\s+' . $className . '\s+extends\s+Component\s*{)/',
                        "$1\n    protected \$paginationTheme = 'tailwind';",
                        (string) $content
                    );
                }

                $this->info("Added WithPagination to {$file->getFilename()}");
            }

            // Ensure render method is present
            if (! Str::contains($content, 'public function render()')) {
                $viewPath = Str::kebab(basename($directory)) . '.' . Str::kebab($className);
                $content = preg_replace(
                    '/(}\s*)$/',
                    "\n    public function render()\n    {\n        return view('livewire.{$viewPath}');\n    }\n$1",
                    (string) $content
                );
                $this->info("Added render method to {$file->getFilename()}");
            }

            // Remove hardcoded ->layout() if present
            if (Str::contains($content, '->layout(')) {
                $content = preg_replace(
                    '/return\s+view\([^)]+\)\s*->layout\([^)]+\);/',
                    'return view(\'livewire.' . Str::kebab(basename($directory)) . '.' . Str::kebab($className) . '\');',
                    (string) $content
                );
                $this->info("Removed hardcoded ->layout() in {$file->getFilename()}");
            }

            // Remove hardcoded rtl() method calls
            if (Str::contains($content, '->rtl(')) {
                $content = str_replace('->rtl()', '', $content);
                $this->info("Removed rtl() method calls in {$file->getFilename()}");
            }

            // Save changes if any were made
            if ($content !== $originalContent) {
                // Create backup
                File::put($file->getPathname() . '.bak', $originalContent);
                $this->info("Created backup of {$file->getFilename()}");

                // Save changes
                File::put($file->getPathname(), $content);
                $this->info("Updated {$file->getFilename()}");
            }
        }
    }
}
