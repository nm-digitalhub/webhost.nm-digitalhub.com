<?php

namespace App\Filament\Resources\ClientModuleResource\Pages;

use App\Filament\Resources\ClientModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientModule extends EditRecord
{
    protected static string $resource = ClientModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('מחק'),
            Actions\Action::make('toggle_status')
                ->label(fn (): string => $this->record->enabled ? 'השבת' : 'הפעל')
                ->color(fn (): string => $this->record->enabled ? 'danger' : 'success')
                ->icon(fn (): string => $this->record->enabled ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                ->action(function (): void {
                    $this->record->update(['enabled' => !$this->record->enabled]);
                    $this->refreshFormData(['enabled']);
                    $this->notify('success', $this->record->enabled ? 'המודול הופעל בהצלחה' : 'המודול הושבת בהצלחה');
                }),
        ];
    }
}