<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FixResourceGetPages extends Command
{
    protected $signature = 'filament:fix-get-pages';

    protected $description = 'Fix Filament Resource getPages() method implementation';

    public function handle()
    {
        $this->info('Checking Filament Resources for incorrect getPages() methods...');

        $resourceDirs = [
            app_path('Filament/Resources'),
        ];

        $fixedFiles = 0;

        foreach ($resourceDirs as $resourceDir) {
            if (! File::isDirectory($resourceDir)) {
                $this->warn("Directory not found: {$resourceDir}");

                continue;
            }

            $resourceFiles = File::files($resourceDir);

            foreach ($resourceFiles as $file) {
                if (! Str::endsWith($file->getFilename(), 'Resource.php')) {
                    continue;
                }

                $content = File::get($file->getPathname());
                $resourceName = pathinfo($file->getFilename(), PATHINFO_FILENAME);

                // Check if getPages() contains string return values
                if (preg_match('/function\s+getPages\s*\(\s*\)[^{]*\{\s*return\s*\[\s*[\'"]([^\'"]+)[\'"]\s*=>\s*[\'"]([^\'"]+)[\'"]/m', $content)) {
                    $this->warn("Found string-based getPages() in {$resourceName}");

                    // Add Pages use statement if missing
                    $namespace = $this->getNamespace($content);
                    if ($namespace) {
                        $pagesUse = "use {$namespace}\\{$resourceName}\\Pages;";
                        if (! Str::contains($content, $pagesUse)) {
                            $content = preg_replace(
                                '/(namespace\s+[^;]+;\s+)/m',
                                "$1\n{$pagesUse}\n",
                                $content
                            );
                        }
                    }

                    // Fix the getPages method
                    $content = preg_replace_callback(
                        '/(function\s+getPages\s*\(\s*\)[^{]*\{\s*return\s*\[)(.*?)(\]\s*;\s*\})/ms',
                        function ($matches) {
                            $prefix = $matches[1];
                            $pageDefinitions = $matches[2];
                            $suffix = $matches[3];

                            // Convert string page definitions to object references
                            $pageDefinitions = preg_replace_callback(
                                '/[\'"]([\w-]+)[\'"](?:\s*=>\s*)[\'"]([^\'"]+)[\'"]/m',
                                function ($pageDef) {
                                    $key = $pageDef[1];
                                    $class = $pageDef[2];
                                    $shortClass = Str::afterLast($class, '\\');

                                    // Determine route based on common page patterns
                                    $route = '/';
                                    if (Str::contains($shortClass, 'Create')) {
                                        $route = '/create';
                                    } elseif (Str::contains($shortClass, 'Edit')) {
                                        $route = '/{record}/edit';
                                    } elseif (Str::contains($shortClass, 'View')) {
                                        $route = '/{record}';
                                    }

                                    return "'{$key}' => Pages\\{$shortClass}::route('{$route}')";
                                },
                                $pageDefinitions
                            );

                            return "{$prefix}{$pageDefinitions}{$suffix}";
                        },
                        (string) $content
                    );

                    // Add type hint if missing
                    $content = preg_replace(
                        '/(function\s+getPages\s*\(\s*\))([^:])/m',
                        '$1: array$2',
                        (string) $content
                    );

                    File::put($file->getPathname(), $content);
                    $this->info("Fixed getPages() in {$resourceName}");
                    $fixedFiles++;
                }
            }
        }

        if ($fixedFiles === 0) {
            $this->info('No resources with incorrect getPages() methods found.');
        } else {
            $this->info("Fixed getPages() in {$fixedFiles} resource(s).");
        }

        return 0;
    }

    private function getNamespace($content)
    {
        if (preg_match('/namespace\s+([^;]+);/m', (string) $content, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
