<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CleanupProject extends Command
{
    protected $signature = 'project:cleanup';

    protected $description = 'Perform full project cleanup and validation';

    public function handle()
    {
        $this->info('Starting full project cleanup...');

        // Run all our custom fixers
        $this->call('fix:php-tags');
        $this->call('filament:fix-page-registrations');
        $this->call('filament:fix-get-pages');
        $this->call('livewire:fix-namespaces');
        $this->call('views:detect-misplaced');
        $this->call('check:php-syntax');

        // Clear all Laravel caches
        $this->info('Clearing Laravel caches...');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        $this->info('Project cleanup completed!');

        return 0;
    }
}
