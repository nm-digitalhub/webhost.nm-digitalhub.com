<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleManagerResource\Pages;
use App\Models\ModuleManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * ModuleManagerResource
 *
 * A resource for managing and viewing all Filament components in the application.
 * Provides a unified interface for Resources, Pages, Widgets, and Livewire components.
 */
class ModuleManagerResource extends Resource
{
    protected static ?string $model = ModuleManager::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationGroup = 'ניהול מערכת';

    protected static ?string $modelLabel = 'רכיבי מערכת';

    protected static ?string $pluralModelLabel = 'רכיבי מערכת';

    /**
     * Get the resource's navigation sort
     * Position this early in navigation to make it easily accessible
     */
    protected static ?int $navigationSort = 10;

    /**
     * Always show this resource in the navigation
     */
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    /**
     * Define the form schema
     *
     * This form is mostly informational since we're not creating/editing actual records
     * but rather viewing and managing existing components
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('פרטי הרכיב')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('שם הרכיב')
                            ->required()
                            ->disabled(),

                        Forms\Components\Select::make('type')
                            ->label('סוג')
                            ->options([
                                'resources' => 'Resource',
                                'pages' => 'Page',
                                'widgets' => 'Widget',
                                'livewire' => 'Livewire Component',
                            ])
                            ->required()
                            ->disabled(),

                        Forms\Components\TextInput::make('class')
                            ->label('מחלקה מלאה')
                            ->disabled(),

                        Forms\Components\TextInput::make('path')
                            ->label('נתיב קובץ')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('סטטוס ומצב')
                    ->schema([
                        Forms\Components\Toggle::make('exists')
                            ->label('קיים פיזית')
                            ->disabled(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('פעיל')
                            ->disabled(),

                        Forms\Components\Toggle::make('is_generated')
                            ->label('נוצר אוטומטית')
                            ->disabled(),

                        Forms\Components\TextInput::make('last_modified')
                            ->label('עודכן לאחרונה')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('מידע נוסף')
                    ->schema([
                        Forms\Components\KeyValue::make('metadata')
                            ->label('מידע ומאפיינים נוספים'),
                    ]),
            ]);
    }

    /**
     * Define the table for displaying all components
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('שם הרכיב')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('סוג')
                    ->colors([
                        'primary' => 'resources',
                        'success' => 'pages',
                        'warning' => 'widgets',
                        'danger' => 'livewire',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'resources' => 'Resource',
                        'pages' => 'Page',
                        'widgets' => 'Widget',
                        'livewire' => 'Livewire',
                        default => $state
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('path')
                    ->label('נתיב')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn ($record) => $record['path']),

                Tables\Columns\IconColumn::make('exists')
                    ->label('קיים')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('פעיל')
                    ->boolean(),

                Tables\Columns\BadgeColumn::make('source')
                    ->label('מקור')
                    ->colors([
                        'success' => 'מחולל',
                        'secondary' => 'ידני',
                    ]),

                Tables\Columns\TextColumn::make('last_modified')
                    ->label('עודכן לאחרונה')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('last_modified', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('סוג')
                    ->options([
                        'resources' => 'Resource',
                        'pages' => 'Page',
                        'widgets' => 'Widget',
                        'livewire' => 'Livewire',
                    ]),

                Tables\Filters\TernaryFilter::make('is_generated')
                    ->label('נוצר אוטומטית'),

                Tables\Filters\TernaryFilter::make('exists')
                    ->label('קיים פיזית'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('פעיל'),

                Tables\Filters\Filter::make('last_modified')
                    ->label('עודכן לאחרונה')
                    ->form([
                        Forms\Components\DatePicker::make('updated_from')
                            ->label('מתאריך'),
                        Forms\Components\DatePicker::make('updated_until')
                            ->label('עד תאריך'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['updated_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('last_modified', '>=', $date),
                        )
                        ->when(
                            $data['updated_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('last_modified', '<=', $date),
                        )),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('הצג')
                    ->icon('heroicon-o-eye')
                    ->url(fn (array $record): string => $record['edit_url'] ?? '#')
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('edit_in_generator')
                    ->label('ערוך במחולל')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (array $record): string => $record['generator_url'] ?? '#')
                    ->openUrlInNewTab()
                    ->visible(fn (array $record): bool => $record['is_generated'] ?? false),

                Tables\Actions\Action::make('view_code')
                    ->label('צפה בקוד')
                    ->icon('heroicon-o-code-bracket')
                    ->url(fn (array $record): string => route('filament.admin.resources.module-managers.view-code', ['path' => $record['path']]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([]);
    }

    /**
     * Define the relations (none for this resource)
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Define the resource pages
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModuleManagers::route('/'),
            'view-code' => Pages\ViewComponentCode::route('/{path}/code'),
        ];
    }
}
