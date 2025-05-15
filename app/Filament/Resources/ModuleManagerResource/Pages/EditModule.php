<?php

declare(strict_types=1);

namespace App\Filament\Resources\ModuleManagerResource\Pages;

use App\Filament\Resources\ModuleManagerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModule extends EditRecord
{
    protected static string $resource = ModuleManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
