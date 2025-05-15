<?php

declare(strict_types=1);

namespace App\Filament\Resources\GenerationLogResource\Pages;

use App\Filament\Resources\GenerationLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGenerationLog extends CreateRecord
{
    protected static string $resource = GenerationLogResource::class;
}
