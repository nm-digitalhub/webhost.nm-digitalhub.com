<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ClientModuleResource\Pages;
use App\Models\ClientModule;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ClientModuleResource extends Resource
{
    protected static ?string $model = ClientModule::class;

    protected static ?string $navigationGroup = 'מנהל מודולים';

    protected static ?string $modelLabel = 'מודול לקוח';

    protected static ?string $pluralModelLabel = 'מודולים ללקוח';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientModules::route('/'),
            'create' => Pages\CreateClientModule::route('/create'),
            'edit' => Pages\EditClientModule::route('/{record}/edit'),
        ];
    }
}
