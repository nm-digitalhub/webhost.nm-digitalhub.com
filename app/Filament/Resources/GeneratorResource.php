<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\GeneratorResource\Pages;
use App\Models\Generator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GeneratorResource extends Resource
{
    protected static ?string $model = Generator::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'ניהול מערכת';

    protected static ?string $modelLabel = 'מחולל';

    protected static ?string $pluralModelLabel = 'מחוללים';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('generator_tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('basic_settings')
                            ->label('הגדרות בסיסיות')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('שם המחולל')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('שם הקובץ שייווצר, ללא סיומת')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $state, callable $set, Forms\Get $get) {
                                        if (blank($get('label'))) {
                                            $set('label', Str::title($state));
                                        }
                                    }),

                                Forms\Components\Select::make('type')
                                    ->label('סוג')
                                    ->options([
                                        'model' => 'Model',
                                        'resource' => 'Resource',
                                        'page' => 'Page',
                                        'widget' => 'Widget',
                                    ])
                                    ->required()
                                    ->live(),

                                Forms\Components\Textarea::make('description')
                                    ->label('תיאור')
                                    ->rows(3),

                                Forms\Components\TextInput::make('namespace')
                                    ->label('Namespace')
                                    ->placeholder(function (Forms\Get $get) {
                                        $type = $get('type');

                                        return match ($type) {
                                            'model' => 'App\\Models',
                                            'resource' => 'App\\Filament\\Resources',
                                            'page' => 'App\\Filament\\Pages',
                                            'widget' => 'App\\Filament\\Widgets',
                                            default => 'App',
                                        };
                                    }),

                                Forms\Components\TextInput::make('target_path')
                                    ->label('נתיב יעד')
                                    ->placeholder(function (Forms\Get $get) {
                                        $type = $get('type');
                                        $name = $get('name');

                                        return match ($type) {
                                            'model' => app_path('Models/'.$name.'.php'),
                                            'resource' => app_path('Filament/Resources/'.$name.'Resource.php'),
                                            'page' => app_path('Filament/Pages/'.$name.'.php'),
                                            'widget' => app_path('Filament/Widgets/'.$name.'.php'),
                                            default => app_path(),
                                        };
                                    })
                                    ->helperText('אם לא מצוין, יווצר לפי מוסכמות Laravel'),

                                Forms\Components\Toggle::make('preview_before_generate')
                                    ->label('הצג תצוגה מקדימה לפני יצירה')
                                    ->default(true),

                                Forms\Components\Toggle::make('confirm_overwrite')
                                    ->label('אשר דריסה של קבצים קיימים')
                                    ->default(true),
                            ]),

                        Forms\Components\Tabs\Tab::make('model_settings')
                            ->label('הגדרות Model')
                            ->schema([
                                Forms\Components\TextInput::make('extends')
                                    ->label('Extends')
                                    ->placeholder(\Illuminate\Database\Eloquent\Model::class)
                                    ->helperText('המחלקה שממנה המודל יורש'),

                                Forms\Components\TagsInput::make('implements')
                                    ->label('Implements')
                                    ->helperText('Interfaces שהמודל מממש')
                                    ->placeholder('הוסף interface'),

                                Forms\Components\TagsInput::make('traits')
                                    ->label('Traits')
                                    ->helperText('Traits שהמודל משתמש בהם')
                                    ->placeholder('הוסף trait'),

                                Forms\Components\Toggle::make('fillable')
                                    ->label('כלול מערך fillable')
                                    ->default(true),

                                Forms\Components\Toggle::make('timestamps')
                                    ->label('כלול timestamps')
                                    ->default(true),

                                Forms\Components\Toggle::make('soft_deletes')
                                    ->label('כלול soft deletes')
                                    ->default(false),

                                Forms\Components\Repeater::make('fields')
                                    ->label('שדות המודל')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('שם השדה')
                                            ->required(),
                                        Forms\Components\Select::make('type')
                                            ->label('סוג')
                                            ->options([
                                                'string' => 'String',
                                                'integer' => 'Integer',
                                                'boolean' => 'Boolean',
                                                'text' => 'Text',
                                                'date' => 'Date',
                                                'datetime' => 'DateTime',
                                                'decimal' => 'Decimal',
                                                'json' => 'JSON',
                                                'timestamp' => 'Timestamp',
                                            ])
                                            ->required(),
                                        Forms\Components\Toggle::make('nullable')
                                            ->label('Nullable')
                                            ->default(false),
                                        Forms\Components\TextInput::make('default')
                                            ->label('ערך ברירת מחדל'),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->collapsible()
                                    ->defaultItems(0),

                                Forms\Components\Repeater::make('relations')
                                    ->label('יחסים / Relations')
                                    ->schema([
                                        Forms\Components\Select::make('type')
                                            ->label('סוג')
                                            ->options([
                                                'belongsTo' => 'Belongs To',
                                                'hasOne' => 'Has One',
                                                'hasMany' => 'Has Many',
                                                'belongsToMany' => 'Belongs To Many',
                                            ])
                                            ->required(),
                                        Forms\Components\TextInput::make('name')
                                            ->label('שם המתודה')
                                            ->required(),
                                        Forms\Components\TextInput::make('related_model')
                                            ->label('מודל קשור')
                                            ->required(),
                                        Forms\Components\TextInput::make('foreign_key')
                                            ->label('Foreign Key'),
                                        Forms\Components\TextInput::make('local_key')
                                            ->label('Local Key'),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => ($state['type'] ?? '').' '.($state['name'] ?? ''))
                                    ->collapsible()
                                    ->defaultItems(0),
                            ])
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'model'),

                        Forms\Components\Tabs\Tab::make('resource_settings')
                            ->label('הגדרות Resource')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('תווית/Label')
                                    ->helperText('כותרת תצוגת הריסורס במערכת')
                                    ->live(),

                                Forms\Components\TextInput::make('icon')
                                    ->label('אייקון')
                                    ->placeholder('heroicon-o-document-text')
                                    ->helperText('שם האייקון של Heroicon (עם תחילית heroicon-o/s)'),

                                Forms\Components\TextInput::make('group')
                                    ->label('קבוצת ניווט')
                                    ->placeholder('ניהול תוכן')
                                    ->helperText('הקבוצה שבה הריסורס יופיע בתפריט'),

                                Forms\Components\Repeater::make('form_fields')
                                    ->label('שדות טופס')
                                    ->schema(self::getFormFieldsSchema())
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->collapsible()
                                    ->defaultItems(0),

                                Forms\Components\Repeater::make('table_columns')
                                    ->label('עמודות טבלה')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('שם עמודה')
                                            ->required(),
                                        Forms\Components\Select::make('type')
                                            ->label('סוג')
                                            ->options([
                                                'text' => 'Text',
                                                'icon' => 'Icon',
                                                'image' => 'Image',
                                                'badge' => 'Badge',
                                                'boolean' => 'Boolean',
                                                'color' => 'Color',
                                            ])
                                            ->required(),
                                        Forms\Components\Toggle::make('sortable')
                                            ->label('ניתן למיון')
                                            ->default(true),
                                        Forms\Components\Toggle::make('searchable')
                                            ->label('ניתן לחיפוש')
                                            ->default(false),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->collapsible()
                                    ->defaultItems(0),
                            ])
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'resource'),

                        Forms\Components\Tabs\Tab::make('page_settings')
                            ->label('הגדרות Page')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('תווית/Label')
                                    ->helperText('כותרת הדף'),

                                Forms\Components\TextInput::make('icon')
                                    ->label('אייקון')
                                    ->placeholder('heroicon-o-document-text')
                                    ->helperText('שם האייקון של Heroicon (עם תחילית heroicon-o/s)'),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->placeholder('my-custom-page')
                                    ->helperText('נתיב ה-URL של הדף'),

                                Forms\Components\Toggle::make('navigation_item')
                                    ->label('הצג בתפריט הניווט')
                                    ->default(true),

                                Forms\Components\TextInput::make('group')
                                    ->label('קבוצת ניווט')
                                    ->placeholder('ניהול מערכת')
                                    ->helperText('הקבוצה שבה הדף יופיע בתפריט'),
                            ])
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'page'),

                        Forms\Components\Tabs\Tab::make('widget_settings')
                            ->label('הגדרות Widget')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('תווית/Label')
                                    ->helperText('כותרת הווידג\'ט'),

                                Forms\Components\Select::make('widget_type')
                                    ->label('סוג ווידג\'ט')
                                    ->options([
                                        'stats' => 'Stats Overview',
                                        'chart' => 'Chart',
                                        'list' => 'List',
                                        'table' => 'Table',
                                        'custom' => 'Custom',
                                    ]),

                                Forms\Components\Toggle::make('poll')
                                    ->label('רענון אוטומטי')
                                    ->helperText('האם הווידג\'ט יתרענן אוטומטית'),

                                Forms\Components\TextInput::make('poll_interval')
                                    ->label('תדירות רענון (בשניות)')
                                    ->numeric()
                                    ->default(60)
                                    ->visible(fn (Forms\Get $get): bool => $get('poll') === true),
                            ])
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'widget'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function getFormFieldsSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('שם השדה')
                ->required(),
            Forms\Components\Select::make('type')
                ->label('סוג')
                ->options([
                    'text' => 'Text Input',
                    'textarea' => 'Textarea',
                    'select' => 'Select',
                    'checkbox' => 'Checkbox',
                    'toggle' => 'Toggle',
                    'radio' => 'Radio',
                    'date' => 'Date Picker',
                    'dateTime' => 'Date Time Picker',
                    'file' => 'File Upload',
                    'richText' => 'Rich Text Editor',
                    'hidden' => 'Hidden',
                    'color' => 'Color Picker',
                ])
                ->required(),
            Forms\Components\Toggle::make('required')
                ->label('חובה')
                ->default(false),
            Forms\Components\TextInput::make('label')
                ->label('תווית שדה'),
            Forms\Components\TextInput::make('placeholder')
                ->label('Placeholder'),
            Forms\Components\TextInput::make('helper_text')
                ->label('טקסט עזרה'),
            Forms\Components\Toggle::make('show_in_table')
                ->label('הצג בטבלה')
                ->default(true),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('שם')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('סוג')
                    ->colors([
                        'primary' => 'model',
                        'success' => 'resource',
                        'warning' => 'page',
                        'danger' => 'widget',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('namespace')
                    ->label('Namespace')
                    ->toggleable(true),

                Tables\Columns\TextColumn::make('description')
                    ->label('תיאור')
                    ->limit(50)
                    ->toggleable(),

                Tables\Columns\IconColumn::make('fillable')
                    ->label('Fillable')
                    ->boolean()
                    ->toggleable(true),

                Tables\Columns\IconColumn::make('timestamps')
                    ->label('Timestamps')
                    ->boolean()
                    ->toggleable(true),

                Tables\Columns\IconColumn::make('soft_deletes')
                    ->label('Soft Deletes')
                    ->boolean()
                    ->toggleable(true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('נוצר בתאריך')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('סוג')
                    ->options([
                        'model' => 'Model',
                        'resource' => 'Resource',
                        'page' => 'Page',
                        'widget' => 'Widget',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('ערוך'),
                Tables\Actions\Action::make('generate')
                    ->label('ייצר קוד')
                    ->icon('heroicon-o-code-bracket')
                    ->color('success')
                    ->url(fn (Generator $record): string => route('filament.admin.resources.generators.generate', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('מחק'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGenerators::class,
            'create' => Pages\CreateGenerator::class,
            'edit' => Pages\EditGenerator::class,
            'generate' => Pages\GenerateCode::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [];
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
