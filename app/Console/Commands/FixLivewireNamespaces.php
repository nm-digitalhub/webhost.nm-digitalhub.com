<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixLivewireNamespaces extends Command
{
    protected $signature = 'livewire:fix-namespaces';

    protected $description = 'Fix namespace issues in Livewire components';

    public function handle()
    {
        $this->info('Fixing namespace issues in Livewire components...');

        // Determine correct namespace based on Livewire version
        $correctNamespace = 'App\\Livewire';
        $legacyNamespace = 'App\\Http\\Livewire';

        $this->info("Using namespace: {$correctNamespace}");

        // Check for redundant directories
        if (File::isDirectory(app_path('Livewire/Admin/Admin'))) {
            $this->warn('Found redundant Admin directory');

            // Back up files first
            $backupDir = app_path('Livewire/Admin/backup');
            if (! File::isDirectory($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
            }

            // Copy any files in the redundant directory for backup
            foreach (File::files(app_path('Livewire/Admin/Admin')) as $file) {
                $fileName = $file->getFilename();
                $this->info("Backing up: $fileName");
                File::copy($file->getPathname(), "{$backupDir}/{$fileName}");
            }

            // Fix component files
            foreach (File::files(app_path('Livewire/Admin/Admin')) as $file) {
                $fileName = $file->getFilename();
                $targetPath = app_path("Livewire/Admin/{$fileName}");

                // Only copy if not already exists to avoid conflicts
                if (! File::exists($targetPath)) {
                    $contents = File::get($file->getPathname());
                    $contents = str_replace(
                        "namespace {$legacyNamespace}\\Admin;",
                        "namespace {$correctNamespace}\\Admin;",
                        $contents
                    );
                    File::put($targetPath, $contents);
                    $this->info("Fixed and moved: $fileName");
                } else {
                    $this->warn("File already exists: $fileName - skipped");
                }
            }

            // Can now remove the redundant directory
            $this->info('Removing redundant directory...');
            File::deleteDirectory(app_path('Livewire/Admin/Admin'));
        }

        // Fix namespaces in Admin components
        $this->fixNamespacesInDirectory(app_path('Livewire/Admin'));

        // Fix namespaces in Client components
        $this->fixNamespacesInDirectory(app_path('Livewire/Client'));

        // Verify blade templates exist
        $this->checkForMissingBladeTemplates();

        $this->info('Namespace fixes completed successfully!');

        return 0;
    }

    private function fixNamespacesInDirectory(string $directory)
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
            $fileName = $file->getFilename();
            $expectedNamespace = 'App\\Livewire\\' . basename($directory);

            // Check for incorrect namespaces like App\Http\Livewire
            if (preg_match('/namespace\s+App\\\\Http\\\\Livewire/', $content)) {
                $this->info("Found incorrect namespace in {$fileName}");

                // Replace the incorrect namespace
                $content = preg_replace(
                    '/namespace\s+App\\\\Http\\\\Livewire(\\\\[^;]+)?;/i',
                    "namespace {$expectedNamespace};",
                    $content
                );

                $this->info("Fixed namespace in {$fileName}");
            }
            // Check for missing namespace or other incorrect namespace
            elseif (! preg_match('/namespace\s+' . preg_quote($expectedNamespace) . ';/', $content)) {
                // Extract any existing namespace
                if (preg_match('/namespace\s+([^;]+);/', $content, $matches)) {
                    $content = str_replace(
                        "namespace {$matches[1]};",
                        "namespace {$expectedNamespace};",
                        $content
                    );
                    $this->info("Corrected namespace in {$fileName} from {$matches[1]} to {$expectedNamespace}");
                } else {
                    // If no namespace found, add it after the PHP tag
                    $content = preg_replace(
                        '/^<\?php\s+/s',
                        "<?php\n\nnamespace {$expectedNamespace};\n\n",
                        $content
                    );
                    $this->info("Added namespace to {$fileName}");
                }
            }

            // Check for class name matching file name
            $className = $file->getFilenameWithoutExtension();
            if (! preg_match('/class\s+' . preg_quote($className) . '\s+extends\s+Component/i', (string) $content)) {
                $this->warn("Class name might not match file name in {$fileName}");

                // If we can detect the actual class name, we can fix it
                if (preg_match('/class\s+([a-zA-Z0-9_]+)\s+extends\s+Component/i', (string) $content, $matches)) {
                    $actualClassName = $matches[1];
                    if ($actualClassName !== $className) {
                        $content = str_replace(
                            "class {$actualClassName} extends Component",
                            "class {$className} extends Component",
                            $content
                        );
                        $this->info("Fixed class name in {$fileName} from {$actualClassName} to {$className}");
                    }
                }
            }

            // Save changes if any were made
            if ($content !== $originalContent) {
                // Create backup
                File::put($file->getPathname() . '.bak', $originalContent);
                $this->info("Created backup of {$fileName}");

                // Save changes
                File::put($file->getPathname(), $content);
                $this->info("Updated {$fileName}");
            }
        }
    }

    private function checkForMissingBladeTemplates()
    {
        $this->info('Checking for missing blade templates...');

        foreach (File::allFiles(app_path('Livewire')) as $file) {
            if ($file->getExtension() === 'php') {
                $className = $file->getFilenameWithoutExtension();
                $namespace = str_replace('/', '\\', $file->getRelativePath());

                // Convert class name to kebab case for blade file
                $kebabCase = strtolower((string) preg_replace('/(?<!^)[A-Z]/', '-$0', $className));
                $kebabCase = str_replace('_', '-', $kebabCase);

                $relativePath = strtolower(str_replace('\\', '/', $namespace));
                $viewPath = resource_path("views/livewire/{$relativePath}/{$kebabCase}.blade.php");

                if (! File::exists($viewPath)) {
                    $this->warn("Missing blade template: livewire/{$relativePath}/{$kebabCase}.blade.php");
                }
            }
        }
    }
}
