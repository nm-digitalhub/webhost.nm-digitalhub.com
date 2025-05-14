<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixLivewireNamespaces extends Command
{
    protected $signature = 'livewire:fix-namespaces';

    protected $description = 'Fix Livewire component namespaces and ensure proper structure';

    public function handle()
    {
        $this->info('Checking Livewire component structure...');

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

        // Fix namespaces in all component files
        $this->info('Fixing component namespaces...');
        foreach (File::allFiles(app_path('Livewire')) as $file) {
            if ($file->getExtension() === 'php') {
                $contents = File::get($file->getPathname());
                $originalContents = $contents;

                $contents = str_replace(
                    "namespace {$legacyNamespace}\\",
                    "namespace {$correctNamespace}\\",
                    $contents
                );

                if ($contents !== $originalContents) {
                    File::put($file->getPathname(), $contents);
                    $this->info("Fixed namespace in: {$file->getRelativePathname()}");
                }
            }
        }

        // Verify blade templates exist
        $this->info('Checking blade templates...');
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

        $this->info('Completed fixing Livewire component structure.');
    }
}
