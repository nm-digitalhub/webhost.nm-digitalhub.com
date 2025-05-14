<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FixBladeViews extends Command
{
    protected $signature = 'views:fix-blade';
    protected $description = 'Fix Blade views to comply with Laravel 12 and Filament 3 standards';

    public function handle()
    {
        $this->info('Starting Blade views fixes...');

        // Fix admin views
        $this->fixViewsInDirectory(resource_path('views/livewire/admin'));

        // Fix client views
        $this->fixViewsInDirectory(resource_path('views/livewire/client'));

        // Fix layout views
        $this->fixViewsInDirectory(resource_path('views/layouts'));

        $this->info('Blade views fixes completed successfully!');

        return 0;
    }

    private function fixViewsInDirectory(string $directory)
    {
        if (!File::isDirectory($directory)) {
            $this->warn("Directory not found: {$directory}");
            return;
        }

        $files = File::glob("{$directory}/*.blade.php");
        $this->info("Processing " . count($files) . " blade files in {$directory}");

        foreach ($files as $filePath) {
            $content = File::get($filePath);
            $originalContent = $content;
            $fileName = basename($filePath);

            // Replace @section('content') with x-filament.layouts.app if using admin layout
            if (Str::contains($content, "@section('content')") &&
                (Str::contains(basename($directory), 'admin') || Str::contains($fileName, 'admin'))) {

                $this->info("Replacing content section with Filament layout in {$fileName}");

                // Replace the entire content section structure with Filament layout
                $content = preg_replace(
                    '/@extends\([\'"]layouts\.admin[\'"]\)\s*@section\([\'"]content[\'"]\)(.*?)@endsection/s',
                    '<x-filament-panels::page>$1</x-filament-panels::page>',
                    $content
                );
            }

            // Replace hardcoded strings with localization function
            if (preg_match_all('/(?<![_\'"])([א-ת]{2,}|[A-Za-z]{2,}\s+[A-Za-z]{2,})(?![_\'"])/', $content, $matches)) {
                foreach ($matches[0] as $match) {
                    // Skip if it's already in a translation helper
                    if (preg_match('/__([\'"]).+?\\1/', $match)) {
                        continue;
                    }

                    // Skip if it's in an HTML attribute that should be ignored
                    if (Str::contains($match, ['class=', 'id=', 'name=', 'wire:model', 'x-data'])) {
                        continue;
                    }

                    // Create a translation key from the text
                    $key = Str::snake(Str::ascii(trim($match)));

                    // Replace the text with the translation helper
                    $content = str_replace(
                        $match,
                        "{{ __('{$key}') }}",
                        $content
                    );

                    $this->info("Replaced '{$match}' with translation key '{$key}' in {$fileName}");
                }
            }

            // Add dir attribute for RTL support if needed
            if (!Str::contains($content, 'dir=') && (
                Str::contains($content, '<html') ||
                Str::contains($content, '<body') ||
                Str::contains($content, '<div class="container">')
            )) {
                $content = preg_replace(
                    '/(<html[^>]*|<body[^>]*|<div class="container"[^>]*)>/',
                    '$1 dir="{{ app()->getLocale() === \'he\' ? \'rtl\' : \'ltr\' }}">',
                    $content
                );
                $this->info("Added dynamic dir attribute for RTL support in {$fileName}");
            }

            // Save changes if any were made
            if ($content !== $originalContent) {
                // Create backup
                File::put($filePath . '.bak', $originalContent);
                $this->info("Created backup of {$fileName}");

                // Save changes
                File::put($filePath, $content);
                $this->info("Updated {$fileName}");
            }
        }
    }
}
