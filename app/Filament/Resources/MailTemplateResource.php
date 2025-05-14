<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MailTemplateResource\Pages;
use App\Models\MailTemplate;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class MailTemplateResource extends Resource
{
    protected static ?string $model = MailTemplate::class;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole(['Super-Admin']) ||
               auth()->user()->can('mail.manage');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'הגדרות מערכת';

    protected static ?string $modelLabel = 'תבנית אימייל';

    protected static ?string $pluralModelLabel = 'תבניות אימייל';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('תוכן')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('שם תבנית (מזהה)')
                                    ->helperText('משמש לזיהוי התבנית במערכת, למשל: user_welcome')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('subject')
                                    ->label('נושא האימייל')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\RichEditor::make('body')
                                    ->label('תוכן האימייל')
                                    ->required()
                                    ->fileAttachmentsDirectory(false)
                                    ->toolbarButtons([
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('lang')
                                    ->label('שפה')
                                    ->options([
                                        'en' => 'English',
                                        'he' => 'עברית',
                                    ])
                                    ->default('he')
                                    ->required(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('פעיל')
                                    ->helperText('האם התבנית פעילה?')
                                    ->default(true)
                                    ->required(),
                            ]),

                        Tabs\Tab::make('תצוגה מקדימה')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Section::make('תצוגה מקדימה')
                                    ->schema([
                                        Forms\Components\Placeholder::make('preview_heading')
                                            ->label('תצוגה מקדימה עם נתוני דוגמה')
                                            ->content(function ($record, $state) {
                                                if (! $record && ! $state) {
                                                    return new HtmlString('<div class="p-4 bg-gray-100 rounded text-gray-500 text-center">שמור את התבנית כדי לראות תצוגה מקדימה</div>');
                                                }

                                                $subject = $state['subject'] ?? ($record->subject ?? 'נושא האימייל');
                                                $body = $state['body'] ?? ($record->body ?? 'תוכן האימייל');

                                                return new HtmlString(
                                                    '<div class="preview-frame bg-white shadow rounded-lg overflow-hidden">'.
                                                    '<div class="border-b border-gray-200 bg-gray-50 px-4 py-3">'.
                                                    '<h3 class="text-lg font-medium">נושא: '.htmlspecialchars($subject).'</h3>'.
                                                    '</div>'.
                                                    '<div class="p-4">'.$body.'</div>'.
                                                    '</div>'
                                                );
                                            }),

                                        Forms\Components\Actions::make([
                                            Forms\Components\Actions\Action::make('refresh_preview')
                                                ->label('רענן תצוגה מקדימה')
                                                ->icon('heroicon-o-arrow-path')
                                                ->action(function ($record, $livewire) {
                                                    $livewire->refreshFormData();
                                                    \Filament\Notifications\Notification::make()
                                                        ->title('תצוגה מקדימה רועננה')
                                                        ->success()
                                                        ->send();
                                                }),
                                        ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('משתנים')
                            ->icon('heroicon-o-variable')
                            ->schema([
                                Forms\Components\TagsInput::make('variables')
                                    ->label('משתנים')
                                    ->helperText('הוסף משתנים שיהיו זמינים בתבנית, למשל: name, email, password')
                                    ->placeholder('הוסף משתנה חדש')
                                    ->suggestions([
                                        'name',
                                        'email',
                                        'password',
                                        'reset_url',
                                        'login_url',
                                        'app_name',
                                        'date',
                                        'verification_url',
                                        'action_url',
                                        'code',
                                    ]),

                                Section::make('תצוגה מקדימה בסימולציית משתנים')
                                    ->schema([
                                        Forms\Components\Actions::make([
                                            Forms\Components\Actions\Action::make('preview_with_variables')
                                                ->label('תצוגה מקדימה עם משתנים')
                                                ->icon('heroicon-o-eye')
                                                ->action(function ($record, $livewire) {
                                                    $variables = $record->variables ?? [];
                                                    $sampleData = [
                                                        'name' => 'משתמש לדוגמה',
                                                        'email' => 'example@example.com',
                                                        'password' => 'סיסמה_לדוגמה_123',
                                                        'reset_url' => 'https://example.com/reset-password?token=sample',
                                                        'login_url' => 'https://example.com/login',
                                                        'app_name' => config('app.name'),
                                                        'verification_url' => 'https://example.com/verify-email?token=sample',
                                                        'action_url' => 'https://example.com/action',
                                                        'code' => '123456',
                                                        'date' => now()->format('Y-m-d H:i:s'),
                                                    ];

                                                    $preview = \App\Services\Mail\MailTemplateManager::preview($record);

                                                    \Filament\Notifications\Notification::make()
                                                        ->title('תצוגה מקדימה')
                                                        ->body(new HtmlString('<div style="max-height:350px;overflow-y:auto;">'.
                                                            '<h3>'.htmlspecialchars((string) $preview['subject']).'</h3>'.
                                                            $preview['body'].'</div>'))
                                                        ->info()
                                                        ->persistent()
                                                        ->send();
                                                }),
                                        ]),
                                    ]),

                                Section::make('רשימת משתנים זמינים')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Placeholder::make('var_name')
                                                    ->label('שם משתמש')
                                                    ->content('{{ name }}'),

                                                Forms\Components\Placeholder::make('var_email')
                                                    ->label('אימייל')
                                                    ->content('{{ email }}'),

                                                Forms\Components\Placeholder::make('var_password')
                                                    ->label('סיסמה')
                                                    ->content('{{ password }}'),

                                                Forms\Components\Placeholder::make('var_login_url')
                                                    ->label('קישור להתחברות')
                                                    ->content('{{ login_url }}'),

                                                Forms\Components\Placeholder::make('var_reset_url')
                                                    ->label('קישור לאיפוס סיסמה')
                                                    ->content('{{ reset_url }}'),

                                                Forms\Components\Placeholder::make('var_verification_url')
                                                    ->label('קישור לאימות אימייל')
                                                    ->content('{{ verification_url }}'),

                                                Forms\Components\Placeholder::make('var_app_name')
                                                    ->label('שם האפליקציה')
                                                    ->content('{{ app_name }}'),

                                                Forms\Components\Placeholder::make('var_date')
                                                    ->label('תאריך')
                                                    ->content('{{ date }}'),

                                                Forms\Components\Placeholder::make('var_code')
                                                    ->label('קוד אימות')
                                                    ->content('{{ code }}'),
                                            ])
                                            ->columns(3),
                                    ]),

                                Section::make('עזרה')
                                    ->schema([
                                        Forms\Components\Placeholder::make('variables_help')
                                            ->label('כיצד להשתמש במשתנים בתבנית')
                                            ->content(new HtmlString(
                                                '<p>יש להשתמש בסינטקס של Blade לצורך שילוב משתנים:</p>'.
                                                '<div class="p-2 bg-gray-100 rounded mb-2"><code>{{ name }}</code> - שם המשתמש</div>'.
                                                '<div class="p-2 bg-gray-100 rounded mb-2"><code>{{ email }}</code> - כתובת אימייל</div>'.
                                                '<div class="p-2 bg-gray-100 rounded mb-4"><code>{{ password }}</code> - סיסמה</div>'.
                                                '<p>דוגמה לתבנית עם משתנים:</p>'.
                                                '<div class="p-4 bg-gray-100 rounded font-mono text-sm whitespace-pre-wrap">שלום {{ name }},

חשבונך נוצר בהצלחה.
פרטי התחברות:
שם משתמש: {{ email }}
סיסמה: {{ password }}

<a href="{{ login_url }}">לחץ כאן להתחברות</a>

בברכה,
צוות {{ app_name }}</div>'
                                            )),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('שם')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('נושא')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lang')
                    ->label('שפה')
                    ->badge(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('פעיל')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('עודכן')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('lang')
                    ->label('שפה')
                    ->options([
                        'en' => 'English',
                        'he' => 'עברית',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('פעיל'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('duplicate')
                    ->label('שכפל')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (MailTemplate $record) {
                        $duplicate = $record->replicate();
                        $duplicate->name = $record->name.'_copy';
                        $duplicate->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('הפעל')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('השבת')
                        ->icon('heroicon-o-x-mark')
                        ->action(fn ($records) => $records->each->update(['is_active' => false])),
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
            'index' => Pages\ListMailTemplates::route('/'),
            'create' => Pages\CreateMailTemplate::route('/create'),
            'edit' => Pages\EditMailTemplate::route('/{record}/edit'),
        ];
    }
}
