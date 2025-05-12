<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunAllFixers extends Command
{
    protected $signature = 'fix:all';
    protected $description = 'Run all fixers to repair the Laravel project';

    public function handle()
    {
        $this->info('Running all project fixers...');

        // Fix critical PHP syntax issues first
        $this->runFixer('fix:duplicate-php-tags', 'Fixing duplicate PHP tags');

        // Fix Filament specific classes
        $this->runFixer('filament:cleanup-classes', 'Cleaning up Filament classes');

        // Run the other fixers
        $this->runFixer('filament:fix-page-registrations', 'Fixing Filament page registrations');
        $this->runFixer('filament:fix-get-pages', 'Fixing Resource getPages methods');
        $this->runFixer('livewire:fix-namespaces', 'Fixing Livewire namespaces');

        // Clear all caches
        $this->info("\n" . str_repeat('-', 50));
        $this->info('Clearing all caches');
        $this->info(str_repeat('-', 50));

        Artisan::call('config:clear');
        $this->info('✓ Config cache cleared');

        Artisan::call('cache:clear');
        $this->info('✓ Application cache cleared');

        Artisan::call('route:clear');
        $this->info('✓ Route cache cleared');

        Artisan::call('view:clear');
        $this->info('✓ View cache cleared');

        Artisan::call('optimize:clear');
        $this->info('✓ Compiled optimization files cleared');

        // Check for any remaining PHP syntax errors
        $this->runFixer('check:php-syntax', 'Checking for remaining PHP syntax errors');

        $this->info("\n" . str_repeat('=', 50));
        $this->info('ALL FIXERS COMPLETED');
        $this->info(str_repeat('=', 50));
        $this->info('If you still have issues, you may need to manually fix some files.');

        return 0;
    }

    private function runFixer($command, $description)
    {
        $this->info("\n" . str_repeat('-', 50));
        $this->info($description);
        $this->info(str_repeat('-', 50));

        Artisan::call($command, [], $this->output);
    }
}
