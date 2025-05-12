<?php

namespace App\Filament\Resources\ClientPageResource\Pages;

use App\Filament\Resources\ClientPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClientPage extends CreateRecord
{
    protected static string $resource = ClientPageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}