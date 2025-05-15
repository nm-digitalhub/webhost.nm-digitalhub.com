<?php

declare(strict_types=1);

namespace App\Filament\Resources\GenerationLogResource\Pages;

use App\Filament\Resources\GenerationLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGenerationLogs extends ListRecords
{
    protected static string $resource = GenerationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
