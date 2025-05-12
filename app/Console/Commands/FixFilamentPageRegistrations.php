<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FixFilamentPageRegistrations extends Command
{
    protected $signature = 'filament:fix-page-registrations';
    protected $description = 'Fix "Call to a member function getPage() on string" errors by converting string page registrations to objects';

    public function handle()
    {
        $this->info('Scanning for Filament Resources with string page registrations...');

        $resourceDirs = [
            app_path('Filament/Resources'),
            app_path('Filament/Admin/Resources'),
        ];

        $fixedFiles = 0;

        foreach ($resourceDirs as $resourceDir) {
            if (!File::isDirectory($resourceDir)) {
                $this->warn("Directory not found: {$resourceDir}");
                continue;
            }

            foreach (File::allFiles($resourceDir) as $file) {
                if ($file->getExtension() !== 'php' || !Str::endsWith($file->getFilename(), 'Resource.php')) {
                    continue;
                }

                $content = File::get($file->getPathname());

                // Look for resources with getPages() method
                if (!preg_match('/function\s+getPages\s*\(\s*\)(?::\s*array)?\s*\{/i', $content)) {
                    continue;
                }

                // Check if it returns strings (using regex to match patterns like 'index' => 'Namespace\Class')
                if (!preg_match('/return\s*\[\s*(?:[\'"][^\'"]+[\'"]\s*=>\s*[\'"][^\'"]+[\'"][\s,]*)+\s*\]\s*;/s', $content)) {
                    continue;
                }

                $this->warn("Found Resource with string page registrations: {$file->getRelativePathname()}");

                // Extract resource name
                $resourceName = Str::beforeLast($file->getFilename(), '.php');

                // Add Pages namespace if missing
                $namespaceRegex = '/namespace\s+([^;]+);/';
                if (preg_match($namespaceRegex, $content, $matches)) {
                    $namespace = $matches[1];

                    // Check if Pages use statement exists
                    $pagesUseRegex = '/use\s+' . preg_quote($namespace, '/') . '\\\' . $resourceName . '\\\Pages\s*;/';
                    if (!preg_match($pagesUseRegex, $content)) {
                        // Add Pages use statement after namespace
                        $content = preg_replace(
                            $namespaceRegex,
                            "$0\n\nuse {$namespace}\\{$resourceName}\\Pages;",
                            $content
                        );
                        $this->info("Added Pages namespace import to {$resourceName}");
                    }
                }

                // Replace string-based page registrations with proper PageRegistration objects
                $content = preg_replace_callback(
                    '/function\s+getPages\s*\(\s*\)(?:\s*:\s*array)?\s*\{(.*?)return\s*\[(.*?)\]\s*;(.*?)\}/s',
                    function ($matches) {
                        $beforeReturn = $matches[1];
                        $pageDefinitions = $matches[2];
                        $afterReturn = $matches[3];

                        // Convert each page definition
                        $pageDefinitions = preg_replace_callback(
                            '/[\'"]([\w-]+)[\'"](?:\s*=>\s*)[\'"]([^\'"]+)[\'"]/m',
                            function ($pageDef) {
                                $key = $pageDef[1];
                                $className = Str::afterLast($pageDef[2], '\\');

                                // Map common page types to standard routes
                                $route = '/';
                                if (Str::contains($className, 'Create')) {
                                    $route = '/create';
                                } elseif (Str::contains($className, 'Edit')) {
                                    $route = '/{record}/edit';
                                } elseif (Str::contains($className, 'View')) {
                                    $route = '/{record}';
                                }

                                return "'{$key}' => Pages\\{$className}::route('{$route}')";
                            },
                            $pageDefinitions
                        );

                        return "function getPages(): array {
        $beforeReturn
        return [
            $pageDefinitions
        ];$afterReturn}";
                    },
                    $content
                );

                File::put($file->getPathname(), $content);
                $this->info("Fixed page registrations in: {$file->getRelativePathname()}");
                $fixedFiles++;
            }
        }

        if ($fixedFiles === 0) {
            $this->info('No resources with string page registrations found.');
        } else {
            $this->info("Fixed page registrations in {$fixedFiles} resource(s).");
            $this->info("Run 'php artisan optimize:clear' to clear caches.");
        }

        return 0;
    }
}
