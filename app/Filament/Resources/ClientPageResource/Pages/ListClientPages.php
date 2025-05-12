<?php

namespace App\Filament\Resources\ClientPageResource\Pages;

use App\Filament\Resources\ClientPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientPages extends ListRecords
{
    protected static string $resource = ClientPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('צור עמוד חדש'),
        ];
    }
}