<?php

declare(strict_types=1);

namespace App\Filament\Resources\ModuleManagerResource\Pages;

use App\Filament\Resources\ModuleManagerResource;
use Filament\Resources\Pages\ListRecords;

// Ensure this is present

class ListModuleManagers extends ListRecords
{
    protected static string $resource = ModuleManagerResource::class;
}
