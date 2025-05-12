<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {name} {--type=blade} {--content=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view file for Filament components';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $type = $this->option('type');
        $content = $this->option('content');
        $force = $this->option('force');
        
        // Convert dot notation to directory structure
        $viewPath = resource_path('views/' . str_replace('.', '/', $name) . '.' . $type);
        
        // Check if the file already exists
        if (File::exists($viewPath) && !$force) {
            $this->error("View file {$viewPath} already exists!");
            return 1;
        }
        
        // Create directory if it doesn't exist
        $directory = dirname($viewPath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        
        // Generate default content if not provided
        if (empty($content)) {
            $content = match ($type) {
                'blade.php', 'blade' => $this->getDefaultBladeContent($name),
                default => '',
            };
        }
        
        // Write the file
        File::put($viewPath, $content);
        
        $this->info("View file {$viewPath} created successfully.");
        return 0;
    }
    
    /**
     * Get default content for a Blade view
     */
    protected function getDefaultBladeContent(string $name): string
    {
        // Check if it's a Filament widget or page
        if (str_contains($name, 'filament.widgets')) {
            return <<<'BLADE'
<x-filament-widgets::widget>
    <x-filament::section>
        <div>
            <!-- Widget Content Here -->
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
BLADE;
        } elseif (str_contains($name, 'filament.pages')) {
            return <<<'BLADE'
<x-filament-panels::page>
    <x-filament::section>
        <div>
            <!-- Page Content Here -->
        </div>
    </x-filament::section>
</x-filament-panels::page>
BLADE;
        }
        
        // Default content for other views
        return <<<'BLADE'
<div>
    <!-- View Content -->
</div>
BLADE;
    }
}
