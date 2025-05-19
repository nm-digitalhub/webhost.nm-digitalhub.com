<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DetectMisplacedViews extends Command
{
    protected $signature = 'views:detect-misplaced';

    protected $description = 'Detect PHP files that might be Blade views';

    public function handle()
    {
        $this->info('Checking for misplaced view files...');

        $suspiciousFiles = [];

        // Check all PHP files in resources directory
        foreach (File::allFiles(resource_path()) as $file) {
            if ($file->getExtension() === 'php') {
                $content = File::get($file->getPathname());

                // Look for HTML-like content that might indicate a view
                if (str_contains($content, '<div') ||
                    str_contains($content, '<html') ||
                    str_contains($content, '{{') ||
                    str_contains($content, '@if')) {
                    $suspiciousFiles[] = $file->getPathname();
                    $this->warn("Potential view file saved as PHP: {$file->getPathname()}");

                    // Suggest converting to blade
                    $bladePath = str_replace('.php', '.blade.php', $file->getPathname());
                    $this->info("Suggested action: mv {$file->getPathname()} {$bladePath}");
                }
            }
        }

        // Check for PHP files in incorrect filament locations
        $filamentResourcesDir = app_path('Filament/Resources');

        if (File::isDirectory($filamentResourcesDir)) {
            foreach (File::allFiles($filamentResourcesDir) as $file) {
                if ($file->getExtension() === 'php' &&
                    ! str_contains($file->getPathname(), '/Pages/') &&
                    (str_contains($file->getFilename(), 'List') ||
                     str_contains($file->getFilename(), 'Create') ||
                     str_contains($file->getFilename(), 'Edit'))) {
                    $content = File::get($file->getPathname());

                    // Check if the file extends a Page class
                    if (str_contains($content, 'extends ListRecords') ||
                        str_contains($content, 'extends CreateRecord') ||
                        str_contains($content, 'extends EditRecord')) {
                        $suspiciousFiles[] = $file->getPathname();
                        $this->warn("Filament Page file in wrong location: {$file->getPathname()}");

                        // Suggest moving to Pages directory
                        $resourceName = $this->detectResourceName($file->getPathname());
                        $pageName = $file->getFilename();
                        $correctPath = app_path("Filament/Resources/{$resourceName}/Pages/{$pageName}");

                        $this->info('Suggested action: mkdir -p '.dirname($correctPath));
                        $this->info("Suggested action: mv {$file->getPathname()} {$correctPath}");
                    }
                }
            }
        }

        if ($suspiciousFiles === []) {
            $this->info('No misplaced view files detected.');
        } else {
            $this->info(count($suspiciousFiles).' suspicious files found.');
        }

        return 0;
    }

    private function detectResourceName($path)
    {
        $filename = basename((string) $path);

        // Try to guess the resource name from common prefixes
        foreach (['List', 'Create', 'Edit', 'View'] as $prefix) {
            if (str_starts_with($filename, $prefix)) {
                $remainder = substr($filename, strlen($prefix), -4); // Remove .php

                return $remainder.'Resource';
            }
        }

        // Default fallback
        return 'UnknownResource';
    }
}
