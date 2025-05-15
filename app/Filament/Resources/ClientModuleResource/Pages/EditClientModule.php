<?php

declare(strict_types=1);

namespace App\Filament\Resources\ClientModuleResource\Pages;

use App\Filament\Resources\ClientModuleResource;
use Filament\Resources\Pages\EditRecord;

class EditClientModule extends EditRecord
{
    protected static string $resource = ClientModuleResource::class;
}
