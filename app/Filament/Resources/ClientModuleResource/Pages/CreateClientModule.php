<?php

declare(strict_types=1);

namespace App\Filament\Resources\ClientModuleResource\Pages;

use App\Filament\Resources\ClientModuleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClientModule extends CreateRecord
{
    protected static string $resource = ClientModuleResource::class;
}
