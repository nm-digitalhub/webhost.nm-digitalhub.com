<?php

namespace App\Filament\Resources\ModuleManagerResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class ListModuleManagers extends ListRecords
{
    protected static string \$resource = \App\Filament\Resources\ModuleManagerResource::class;

    public array \$manualModules = [];

    public function mount(): void
    {
        parent::mount();

        // סריקת קבצי Resource ידניים
        \$this->manualModules = \$this->getManualResources();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getManualResources(): array
    {
        \$filesystem = new Filesystem();
        \$resourcePath = app_path('Filament/Resources');

        \$files = collect(\$filesystem->allFiles(\$resourcePath))
            ->filter(fn(\$file) => Str::endsWith(\$file->getFilename(), 'Resource.php'))
            ->map(function (\$file) use (\$resourcePath) {
                \$relativePath = str_replace(base_path() . '/', '', \$file->getRealPath());
                \$class = 'App\\' . str_replace(['/', '.php'], ['\\', ''], Str::after(\$relativePath, 'app/'));
                return [
                    'class' => \$class,
                    'path' => \$relativePath,
                    'source' => 'ידני',
                    'exists' => class_exists(\$class),
                ];
            });

        return \$files->toArray();
    }

    public function render(): \Illuminate\View\View
    {
        return view('filament.resources.module-manager.pages.list-module-managers', [
            'manualModules' => \$this->manualModules,
        ]);
    }
}
