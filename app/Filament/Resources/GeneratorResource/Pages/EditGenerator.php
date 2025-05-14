<?php

namespace App\Filament\Resources\GeneratorResource\Pages;

use App\Filament\Resources\GeneratorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGenerator extends EditRecord
{
    protected static string $resource = GeneratorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate')
                ->label('צור קוד')
                ->icon('heroicon-o-code-bracket')
                ->color('success')
                ->url(fn () => static::getResource()::getUrl('generate', ['record' => $this->getRecord()]))
                ->successNotificationTitle('פעולה הושלמה בהצלחה'),

            Actions\DeleteAction::make(),
        ];
    }
}
