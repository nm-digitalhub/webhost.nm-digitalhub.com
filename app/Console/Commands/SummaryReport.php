<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SummaryReport extends Command
{
    protected $signature = 'project:report';
    protected $description = 'Generate a summary report of project fixes and remaining issues';

    protected $modifiedFiles = [];
    protected $fixedIssues = [];
    protected $remainingIssues = [];

    public function handle()
    {
        $this->info('Generating project summary report...');

        // Track modified files by looking for .bak files
        $this->findBackupFiles();

        // Run checks to find remaining issues
        $this->checkForRemainingIssues();

        // Display the report
        $this->displayReport();

        return 0;
    }

    private function findBackupFiles()
    {
        $backupFiles = File::glob(base_path() . '/**/*.bak');

        foreach ($backupFiles as $backupFile) {
            $originalFile = substr($backupFile, 0, -4); // Remove .bak extension
            $relativePath = str_replace(base_path() . '/', '', $originalFile);

            $this->modifiedFiles[] = $relativePath;

            // Determine what was fixed based on file path
            if (Str::contains($relativePath, 'Livewire')) {
                $this->fixedIssues[] = "Fixed component structure in {$relativePath}";
            } elseif (Str::contains($relativePath, 'Filament/Resources')) {
                $this->fixedIssues[] = "Fixed resource configuration in {$relativePath}";
            } elseif (Str::contains($relativePath, 'views/livewire')) {
                $this->fixedIssues[] = "Fixed blade template in {$relativePath}";
            } elseif (Str::contains($relativePath, 'Providers/Filament')) {
                $this->fixedIssues[] = "Fixed panel configuration in {$relativePath}";
            }
        }
    }

    private function checkForRemainingIssues()
    {
        // Check for Livewire component issues
        $livewireFiles = array_merge(
            File::glob(app_path('Livewire/Admin/*.php')),
            File::glob(app_path('Livewire/Client/*.php'))
        );

        foreach ($livewireFiles as $file) {
            $content = File::get($file);
            $relativePath = str_replace(base_path() . '/', '', $file);

            // Check for missing WithPagination trait when pagination is used
            if (Str::contains($content, ['paginate(', 'simplePaginate(']) &&
                !Str::contains($content, 'use WithPagination;')) {
                $this->remainingIssues[] = "{$relativePath}: Missing WithPagination trait";
            }

            // Check for render() method
            if (!Str::contains($content, 'public function render()')) {
                $this->remainingIssues[] = "{$relativePath}: Missing render() method";
            }
        }

        // Check for Filament Resource issues
        $resourceFiles = File::glob(app_path('Filament/Resources/*.php'));

        foreach ($resourceFiles as $file) {
            $content = File::get($file);
            $relativePath = str_replace(base_path() . '/', '', $file);

            // Check if getPages() returns string paths instead of class references
            if (preg_match('/public\s+static\s+function\s+getPages.*?return\s+\[.*?[\'"](index|create|edit)[\'"].*?\]/s', $content)) {
                $this->remainingIssues[] = "{$relativePath}: getPages() returns string paths instead of class references";
            }
        }

        // Check for AdminPanelProvider issues
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');

        if (File::exists($panelProviderPath)) {
            $content = File::get($panelProviderPath);

            // Check for deprecated rtl() method
            if (Str::contains($content, '->rtl(')) {
                $this->remainingIssues[] = "AdminPanelProvider.php: Using deprecated ->rtl() method";
            }

            // Check for string-based resource paths
            if (Str::contains($content, "->resources(['") || Str::contains($content, "->resources(['"))) {
                $this->remainingIssues[] = "AdminPanelProvider.php: Using string-based resource paths";
            }
        }
    }

    private function displayReport()
    {
        $this->info("\n=== NM-DigitalHUB Laravel 12 Compliance Report ===\n");

        // Modified files section
        $this->info("Modified Files (" . count($this->modifiedFiles) . "):");
        if (count($this->modifiedFiles) > 0) {
            foreach ($this->modifiedFiles as $index => $file) {
                $this->line("  " . ($index + 1) . ". {$file}");
            }
        } else {
            $this->line("  No files were modified.");
        }

        // Fixed issues section
        $this->info("\nFixed Issues (" . count($this->fixedIssues) . "):");
        if (count($this->fixedIssues) > 0) {
            foreach ($this->fixedIssues as $index => $issue) {
                $this->line("  " . ($index + 1) . ". {$issue}");
            }
        } else {
            $this->line("  No issues were fixed.");
        }

        // Remaining issues section
        $this->info("\nRemaining Issues (" . count($this->remainingIssues) . "):");
        if (count($this->remainingIssues) > 0) {
            foreach ($this->remainingIssues as $index => $issue) {
                $this->warn("  " . ($index + 1) . ". {$issue}");
            }
            $this->line("\nPlease address these issues manually or run additional fix commands.");
        } else {
            $this->info("  No remaining issues found! Your project is compliant with Laravel 12 and Filament 3 standards.");
        }

        $this->info("\n=== End of Report ===\n");
    }
}
