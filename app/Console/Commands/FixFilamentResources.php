<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FixFilamentResources extends Command
{
    protected $signature = 'filament:fix-resources';

    protected $description = 'Fix Filament resources to comply with Filament 3 standards';

    public function handle()
    {
        $this->info('Starting Filament resource fixes...');

        // Fix Resource classes to use proper page registrations
        $this->fixResourceGetPages();

        // Check for Admin panel configuration
        $this->checkPanelConfiguration();

        $this->info('Filament resource fixes completed successfully!');

        return 0;
    }

    private function fixResourceGetPages()
    {
        $resourcesDir = app_path('Filament/Resources');
        if (! File::isDirectory($resourcesDir)) {
            $this->warn("Resources directory not found: {$resourcesDir}");

            return;
        }

        $resourceFiles = File::glob("{$resourcesDir}/*.php");
        $this->info('Processing '.count($resourceFiles).' resources');

        foreach ($resourceFiles as $filePath) {
            $content = File::get($filePath);
            $originalContent = $content;
            $fileName = basename($filePath);
            $className = pathinfo($fileName, PATHINFO_FILENAME);

            // Fix getPages() method if it returns strings instead of class references
            if (preg_match('/public\s+static\s+function\s+getPages\s*\(\s*\).*?return\s+\[(.*?)\]/s', $content, $matches)) {
                $pagesContent = $matches[1];

                // Check if pages are defined as strings
                if (preg_match('/[\'"](index|create|edit)[\'"]/', $pagesContent)) {
                    $this->info("Found string-based page registrations in {$fileName}");

                    // Create a fixed version with class references
                    $fixedPagesContent = preg_replace(
                        '/[\'"]index[\'"]\s*=>\s*[\'"][^\'"]+(\'|")/',
                        "'index' => Pages\\\\List{$className}::route('/')",
                        $pagesContent
                    );

                    $fixedPagesContent = preg_replace(
                        '/[\'"]create[\'"]\s*=>\s*[\'"][^\'"]+(\'|")/',
                        "'create' => Pages\\\\Create{$className}::route('/create')",
                        $fixedPagesContent
                    );

                    $fixedPagesContent = preg_replace(
                        '/[\'"]edit[\'"]\s*=>\s*[\'"][^\'"]+(\'|")/',
                        "'edit' => Pages\\\\Edit{$className}::route('/{record}/edit')",
                        $fixedPagesContent
                    );

                    // Replace the pages array with our fixed version
                    $content = preg_replace(
                        '/public\s+static\s+function\s+getPages\s*\(\s*\).*?return\s+\[(.*?)\]/s',
                        "public static function getPages(): array\n    {\n        return [$fixedPagesContent]",
                        $content
                    );

                    $this->info("Fixed getPages() in {$fileName}");
                }
            }

            // Save changes if any were made
            if ($content !== $originalContent) {
                // Create backup
                File::put($filePath.'.bak', $originalContent);
                $this->info("Created backup of {$fileName}");

                // Save changes
                File::put($filePath, $content);
                $this->info("Updated {$fileName}");
            }
        }
    }

    private function checkPanelConfiguration()
    {
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');
        if (! File::exists($panelProviderPath)) {
            $this->warn("AdminPanelProvider not found at: {$panelProviderPath}");

            return;
        }

        $content = File::get($panelProviderPath);
        $originalContent = $content;

        // Check for deprecated rtl() method
        if (Str::contains($content, '->rtl(')) {
            $this->info('Found deprecated ->rtl() method in AdminPanelProvider');

            // Replace with direction() method using locale-based direction
            $content = preg_replace(
                '/->rtl\([^)]*\)/',
                "->direction(App::getLocale() === 'he' ? 'rtl' : 'ltr')",
                $content
            );

            // Ensure App facade is imported
            if (! Str::contains($content, 'use Illuminate\Support\Facades\App;')) {
                $content = preg_replace(
                    '/namespace[^;]+;\s+/',
                    "$0\nuse Illuminate\Support\Facades\App;\n",
                    $content
                );
            }

            $this->info('Replaced rtl() with direction() in AdminPanelProvider');
        }

        // Check for string paths in resource registration
        if (Str::contains($content, ["->resources(['", "->resources(['"]) ||
            preg_match('/->resources\(\[\s*[\'"]/', $content)) {

            $this->warn('Found string-based resource paths in AdminPanelProvider.');
            $this->info("Consider using ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\\\Filament\\\\Resources') instead.");
        }

        // Save changes if any were made
        if ($content !== $originalContent) {
            // Create backup
            File::put($panelProviderPath.'.bak', $originalContent);
            $this->info('Created backup of AdminPanelProvider.php');

            // Save changes
            File::put($panelProviderPath, $content);
            $this->info('Updated AdminPanelProvider.php');
        }
    }
}
