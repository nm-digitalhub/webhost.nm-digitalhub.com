<?php

namespace App\Filament\Resources\ClientPageResource\Pages;

use App\Filament\Resources\ClientPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientPage extends EditRecord
{
    protected static string $resource = ClientPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('מחק'),
            Actions\Action::make('preview')
                ->label('תצוגה מקדימה')
                ->icon('heroicon-o-eye')
                ->url(fn (): string => route('client.pages.show', ['slug' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}