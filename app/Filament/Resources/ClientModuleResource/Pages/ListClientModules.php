<?php

namespace App\Filament\Resources\ClientModuleResource\Pages;

use App\Filament\Resources\ClientModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientModules extends ListRecords
{
    protected static string $resource = ClientModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('צור מודול חדש'),
        ];
    }
}