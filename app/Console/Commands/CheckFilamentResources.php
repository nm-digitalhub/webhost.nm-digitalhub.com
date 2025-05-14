<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CheckFilamentResources extends Command
{
    protected $signature = 'filament:check-resources';

    protected $description = 'Check Filament resources for compliance with Filament 3 standards';

    public function handle()
    {
        $this->info('Checking Filament resources...');

        $resourcesDir = app_path('Filament/Resources');
        $pagesDir = app_path('Filament/Pages');
        $widgetsDir = app_path('Filament/Widgets');

        $issues = [];

        // Check resources
        if (File::isDirectory($resourcesDir)) {
            $resourceFiles = File::allFiles($resourcesDir);
            foreach ($resourceFiles as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $content = File::get($file->getPathname());
                $issues = array_merge($issues, $this->checkResourceFile($file->getPathname(), $content));
            }
        } else {
            $this->warn("Resources directory not found: {$resourcesDir}");
        }

        // Check pages
        if (File::isDirectory($pagesDir)) {
            $pageFiles = File::allFiles($pagesDir);
            foreach ($pageFiles as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $content = File::get($file->getPathname());
                $issues = array_merge($issues, $this->checkPageFile($file->getPathname(), $content));
            }
        } else {
            $this->warn("Pages directory not found: {$pagesDir}");
        }

        // Check widgets
        if (File::isDirectory($widgetsDir)) {
            $widgetFiles = File::allFiles($widgetsDir);
            foreach ($widgetFiles as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $content = File::get($file->getPathname());
                $issues = array_merge($issues, $this->checkWidgetFile($file->getPathname(), $content));
            }
        } else {
            $this->warn("Widgets directory not found: {$widgetsDir}");
        }

        // Output issues
        if (count($issues) > 0) {
            $this->info("\nFound ".count($issues).' issues that need attention:');

            foreach ($issues as $index => $issue) {
                $this->warn(($index + 1).'. '.$issue);
            }

            $this->info("\nPlease fix these issues manually or run the appropriate fix commands.");
        } else {
            $this->info('No issues found! Your Filament resources are compliant with Filament 3 standards.');
        }

        return 0;
    }

    private function checkResourceFile(string $filePath, string $content): array
    {
        $issues = [];
        $fileName = basename($filePath);

        // Check for string-based page registrations
        if (preg_match('/public\s+static\s+function\s+getPages\s*\(\s*\).*?return\s+\[(.*?)\]/s', $content, $matches)) {
            $pagesContent = $matches[1];

            if (preg_match('/[\'"](index|create|edit)[\'"]/', $pagesContent)) {
                $issues[] = "File {$fileName} uses string-based page registrations instead of class references in getPages()";
            }
        }

        // Check for proper form() and table() methods
        if (Str::contains($content, 'public static function form(Form $form)') && ! Str::contains($content, '->schema([')) {
            $issues[] = "File {$fileName} might be missing ->schema([]) in form() method";
        }

        if (Str::contains($content, 'public static function table(Table $table)') && ! Str::contains($content, '->columns([')) {
            $issues[] = "File {$fileName} might be missing ->columns([]) in table() method";
        }

        return $issues;
    }

    private function checkPageFile(string $filePath, string $content): array
    {
        $issues = [];
        $fileName = basename($filePath);

        // Check for proper namespace
        if (! Str::contains($content, 'namespace App\\Filament\\Pages;')) {
            $issues[] = "File {$fileName} might have incorrect namespace";
        }

        // Check for form() method if it's a form page
        if (Str::contains($content, 'extends Page') &&
            Str::contains($content, 'HasForms') &&
            ! Str::contains($content, 'protected function getFormSchema()')) {
            $issues[] = "File {$fileName} uses HasForms but might be missing getFormSchema() method";
        }

        return $issues;
    }

    private function checkWidgetFile(string $filePath, string $content): array
    {
        $issues = [];
        $fileName = basename($filePath);

        // Check for proper namespace
        if (! Str::contains($content, 'namespace App\\Filament\\Widgets;')) {
            $issues[] = "File {$fileName} might have incorrect namespace";
        }

        // Check for proper widget type declaration
        if (Str::contains($content, 'extends Widget') &&
            ! Str::contains($content, 'protected static string $view') &&
            ! Str::contains($content, 'protected function getView()')) {
            $issues[] = "File {$fileName} extends Widget but doesn't define static \$view property or getView() method";
        }

        return $issues;
    }
}
