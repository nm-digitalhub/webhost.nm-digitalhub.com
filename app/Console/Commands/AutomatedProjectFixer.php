<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AutomatedProjectFixer extends Command
{
    protected $signature = 'project:fix
                            {--backup : Create backups of all modified files}
                            {--stage=all : Specify which stage to run (components, views, resources, all)}';

    protected $description = 'Run automated fixes for Laravel 12 and Filament 3 compliance';

    public function handle()
    {
        $this->info('=== NM-DigitalHUB Automated Project Fixer ===');
        $this->info('This will scan and fix common issues with Laravel 12 and Filament 3 compliance.');

        // Check for backup option
        $createBackups = $this->option('backup');
        if ($createBackups) {
            $this->info('Backup mode enabled - all modified files will be backed up before changes.');
        }

        // Get the stage to run
        $stage = $this->option('stage');

        if ($stage === 'all' || $stage === 'components') {
            $this->runStage1ComponentFixes();
        }

        if ($stage === 'all' || $stage === 'views') {
            $this->runStage2ViewFixes();
        }

        if ($stage === 'all' || $stage === 'resources') {
            $this->runStage3ResourceFixes();
        }

        // Clean up and optimize the project
        $this->runCleanupTasks();

        // Generate a summary report
        $this->call('project:report');

        $this->info('Project fix operation completed!');

        return 0;
    }

    private function runStage1ComponentFixes()
    {
        $this->info("\n=== Stage 1: Fixing Livewire Components ===");

        // Run the Livewire component fixer
        $this->call('livewire:fix-components');

        $this->info('Stage 1 completed: Livewire components have been fixed.');
    }

    private function runStage2ViewFixes()
    {
        $this->info("\n=== Stage 2: Fixing Blade Views ===");

        // Run the Blade view fixer
        $this->call('views:fix-blade');

        $this->info('Stage 2 completed: Blade views have been fixed.');
    }

    private function runStage3ResourceFixes()
    {
        $this->info("\n=== Stage 3: Fixing Filament Resources and Panel Integration ===");

        // Run the Filament resource fixer
        $this->call('filament:fix-resources');

        // Run checks on Filament resources
        $this->call('filament:check-resources');

        $this->info('Stage 3 completed: Filament resources and panel integration have been fixed.');
    }

    private function runCleanupTasks()
    {
        $this->info("\n=== Final Stage: Cleaning up and optimizing ===");

        // Run route and import scanner
        $this->info('Scanning routes and imports...');
        if ($this->option('backup')) {
            $this->call('project:scan-routes-imports', ['--report' => true]);
        } else {
            $this->call('project:scan-routes-imports', ['--fix' => true, '--report' => true]);
        }

        // Clear all caches
        $this->info('Clearing Laravel caches...');
        Artisan::call('optimize:clear');
        $this->info(Artisan::output());

        // Dump autoload
        $this->info('Running composer dump-autoload...');
        exec('composer dump-autoload');

        $this->info('Cleanup tasks completed.');
    }
}
