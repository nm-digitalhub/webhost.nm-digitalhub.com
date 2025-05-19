<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\GenerationLogResource\Pages;
use App\Models\GenerationLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GenerationLogResource extends Resource
{
    protected static ?string $model = GenerationLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'ניהול מערכת';

    protected static ?string $modelLabel = 'לוג ייצור קוד';

    protected static ?string $pluralModelLabel = 'לוגים של ייצור קוד';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('משתמש')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('generator_id')
                    ->label('מחולל')
                    ->relationship('generator', 'name')
                    ->searchable(),

                Forms\Components\Select::make('entity_type')
                    ->label('סוג')
                    ->options([
                        'model' => 'Model',
                        'resource' => 'Resource',
                        'page' => 'Page',
                        'widget' => 'Widget',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('entity_name')
                    ->label('שם הישות')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('namespace')
                    ->label('Namespace')
                    ->maxLength(255),

                Forms\Components\Textarea::make('command')
                    ->label('פקודה')
                    ->columnSpanFull()
                    ->disabled(),

                Forms\Components\KeyValue::make('params')
                    ->label('פרמטרים')
                    ->columnSpanFull()
                    ->disabled(),

                Forms\Components\Select::make('status')
                    ->label('סטטוס')
                    ->options([
                        'success' => 'הצלחה',
                        'error' => 'שגיאה',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('error_message')
                    ->label('הודעת שגיאה')
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get): bool => $get('status') === 'error'),

                Forms\Components\Textarea::make('file_path')
                    ->label('נתיב הקובץ')
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('overwritten')
                    ->label('האם דרס קובץ קיים')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('תאריך')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('משתמש')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('generator.name')
                    ->label('מחולל')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('entity_type')
                    ->label('סוג')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'model' => 'primary',
                        'resource' => 'success',
                        'page' => 'warning',
                        'widget' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('entity_name')
                    ->label('שם')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('סטטוס')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'error' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('overwritten')
                    ->label('דרס קובץ')
                    ->boolean(),

                Tables\Columns\TextColumn::make('file_path')
                    ->label('נתיב')
                    ->toggleable(true),

                Tables\Columns\TextColumn::make('namespace')
                    ->label('Namespace')
                    ->searchable()
                    ->toggleable(true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('entity_type')
                    ->label('סוג')
                    ->options([
                        'model' => 'Model',
                        'resource' => 'Resource',
                        'page' => 'Page',
                        'widget' => 'Widget',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('סטטוס')
                    ->options([
                        'success' => 'הצלחה',
                        'error' => 'שגיאה',
                    ]),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('משתמש')
                    ->relationship('user', 'name'),

                Tables\Filters\SelectFilter::make('generator_id')
                    ->label('מחולל')
                    ->relationship('generator', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGenerationLogs::class,
            'create' => Pages\CreateGenerationLog::class,
            'edit' => Pages\EditGenerationLog::class,
        ];
    }

    public static function isEmailVerificationRequired(\Filament\Panel $panel): bool
    {
        return $panel->isEmailVerificationRequired();
    }

    public static function isTenantSubscriptionRequired(\Filament\Panel $panel): bool
    {
        return $panel->isTenantSubscriptionRequired();
    }
}
