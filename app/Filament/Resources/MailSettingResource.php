<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\MailSettingResource\Pages;
use App\Models\MailSetting;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class MailSettingResource extends Resource
{
    protected static ?string $model = MailSetting::class;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole(['Super-Admin']) ||
               auth()->user()->can('mail.manage');
    }

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'הגדרות מערכת';

    protected static ?string $modelLabel = 'הגדרות דואר';

    protected static ?string $pluralModelLabel = 'הגדרות דואר';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('הגדרות SMTP')
                    ->description('הגדרת חשבון SMTP לשליחת דואר אלקטרוני')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('פעיל')
                            ->helperText('האם להשתמש בהגדרות אלו?')
                            ->required(),

                        Forms\Components\Toggle::make('oauth_mode_enabled')
                            ->label('Google OAuth')
                            ->helperText('השתמש ב-Google OAuth במקום סיסמה רגילה')
                            ->reactive(),

                        Forms\Components\Select::make('driver')
                            ->label('סוג החיבור')
                            ->options([
                                'smtp' => 'SMTP',
                                'sendmail' => 'Sendmail',
                                'log' => 'Log (Debug)',
                            ])
                            ->default('smtp')
                            ->required(),

                        Forms\Components\TextInput::make('host')
                            ->label('שרת SMTP')
                            ->placeholder('smtp.gmail.com')
                            ->required()
                            ->visible(fn ($get) => $get('driver') === 'smtp'),

                        Forms\Components\TextInput::make('port')
                            ->label('פורט')
                            ->placeholder('587')
                            ->required()
                            ->visible(fn ($get) => $get('driver') === 'smtp'),

                        Forms\Components\TextInput::make('username')
                            ->label('שם משתמש')
                            ->visible(fn ($get) => $get('driver') === 'smtp'),

                        Forms\Components\TextInput::make('password')
                            ->label('סיסמה')
                            ->password()
                            ->visible(fn ($get) => $get('driver') === 'smtp' && ! $get('oauth_mode_enabled')),

                        Forms\Components\Select::make('encryption')
                            ->label('הצפנה')
                            ->options([
                                'tls' => 'TLS',
                                'ssl' => 'SSL',
                                '' => 'None',
                            ])
                            ->default('tls')
                            ->visible(fn ($get) => $get('driver') === 'smtp'),
                    ]),

                Section::make('הגדרות Google OAuth')
                    ->description('הגדרת Google OAuth לאישור שליחת דואר אלקטרוני דרך Gmail')
                    ->visible(fn ($get) => $get('oauth_mode_enabled'))
                    ->schema([
                        Forms\Components\TextInput::make('google_client_id')
                            ->label('מזהה לקוח Google')
                            ->helperText('Client ID שקיבלת מ-Google Cloud Console'),

                        Forms\Components\TextInput::make('google_client_secret')
                            ->label('סוד לקוח Google')
                            ->password()
                            ->helperText('Client Secret שקיבלת מ-Google Cloud Console'),

                        Forms\Components\TextInput::make('google_redirect_uri')
                            ->label('כתובת הפנייה')
                            ->placeholder(url('/oauth/google/callback'))
                            ->helperText('כתובת ה-Redirect URI שהגדרת ב-Google Cloud Console'),

                        Forms\Components\TextInput::make('google_json_path')
                            ->label('נתיב לקובץ JSON')
                            ->placeholder('/var/www/secure-configs/google/client_secret.json')
                            ->helperText('נתיב מלא לקובץ JSON שהורדת מ-Google Cloud Console (אופציונלי)'),

                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('authenticate_google')
                                ->label('התחבר ל-Google')
                                ->color('primary')
                                ->icon('heroicon-o-lock-open')
                                ->url(fn () => route('oauth.google.redirect'))
                                ->openUrlInNewTab(),
                        ]),
                    ]),

                Section::make('הגדרות שולח')
                    ->schema([
                        Forms\Components\TextInput::make('from_address')
                            ->label('כתובת אימייל השולח')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('from_name')
                            ->label('שם השולח')
                            ->required(),

                        Forms\Components\TextInput::make('reply_to_address')
                            ->label('כתובת למענה')
                            ->email()
                            ->hint('אם ריק, תשתמש בכתובת השולח'),

                        Forms\Components\TextInput::make('reply_to_name')
                            ->label('שם למענה')
                            ->hint('אם ריק, תשתמש בשם השולח'),

                        Forms\Components\Toggle::make('use_no_reply')
                            ->label('השתמש בכתובת no-reply')
                            ->helperText('אם מופעל, מענה יישלח לכתובת noreply@domain.com')
                            ->reactive()
                            ->disabled(fn ($get) => ! empty($get('reply_to_address'))),

                        Forms\Components\Select::make('default_language')
                            ->label('שפת ברירת מחדל')
                            ->options([
                                'he' => 'עברית',
                                'en' => 'English',
                            ])
                            ->default('he')
                            ->required(),

                        Forms\Components\RichEditor::make('signature')
                            ->label('חתימה לתחתית האימייל')
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make()
                    ->schema([
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('test_mail')
                                ->label('שלח אימייל לבדיקה')
                                ->color('success')
                                ->action(function (Forms\Get $get, $state, $record) {
                                    try {
                                        // Save settings temporarily if it's a new record
                                        if (! $record) {
                                            $data = $get->all();
                                            $settings = new MailSetting($data);
                                        } else {
                                            $settings = $record;
                                        }

                                        // Configure mail with these settings
                                        config([
                                            'mail.default' => $settings->driver,
                                            'mail.mailers.smtp.host' => $settings->host,
                                            'mail.mailers.smtp.port' => $settings->port,
                                            'mail.mailers.smtp.username' => $settings->username,
                                            'mail.mailers.smtp.password' => $settings->password,
                                            'mail.mailers.smtp.encryption' => $settings->encryption,
                                            'mail.from.address' => $settings->from_address,
                                            'mail.from.name' => $settings->from_name,
                                        ]);

                                        // Apply Google OAuth if enabled
                                        if ($settings->oauth_mode_enabled) {
                                            app(\App\Services\Mail\GoogleOAuthService::class)->setupClient()->applyToMailer();
                                        }

                                        // Get test template if exists
                                        $template = \App\Models\MailTemplate::where('name', 'test_email')
                                            ->where('lang', $settings->default_language)
                                            ->first();

                                        // Send test email
                                        if ($template) {
                                            // Use template
                                            $rendered = \App\Services\Mail\MailTemplateManager::render(
                                                $template,
                                                null,
                                                [
                                                    'name' => 'Test User',
                                                    'email' => $settings->from_address,
                                                    'date' => now()->format('Y-m-d H:i:s'),
                                                    'app_name' => config('app.name'),
                                                ]
                                            );

                                            Mail::send('emails.template', ['content' => $rendered['body']], function (Message $message) use ($settings, $rendered) {
                                                $message->to($settings->from_address)
                                                    ->subject($rendered['subject']);

                                                if (! empty($settings->reply_to_address)) {
                                                    $message->replyTo($settings->reply_to_address, $settings->reply_to_name);
                                                } elseif ($settings->use_no_reply) {
                                                    $message->replyTo('noreply@'.parse_url((string) config('app.url'), PHP_URL_HOST), 'No Reply');
                                                }
                                            });
                                        } else {
                                            // Fallback to simple text email
                                            Mail::raw('This is a test email from '.config('app.name')."\n\nSent at: ".now()->format('Y-m-d H:i:s'), function (Message $message) use ($settings) {
                                                $message->to($settings->from_address)
                                                    ->subject('Test Email from '.config('app.name'));

                                                if (! empty($settings->reply_to_address)) {
                                                    $message->replyTo($settings->reply_to_address, $settings->reply_to_name);
                                                } elseif ($settings->use_no_reply) {
                                                    $message->replyTo('noreply@'.parse_url((string) config('app.url'), PHP_URL_HOST), 'No Reply');
                                                }
                                            });
                                        }

                                        Notification::make()
                                            ->title('אימייל נשלח בהצלחה')
                                            ->body('נשלח אימייל לכתובת: '.$settings->from_address)
                                            ->success()
                                            ->send();
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title('שגיאה בשליחת אימייל')
                                            ->body($e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                }),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_active')
                    ->label('פעיל')
                    ->boolean(),
                Tables\Columns\TextColumn::make('driver')
                    ->label('סוג')
                    ->badge(),
                Tables\Columns\TextColumn::make('host')
                    ->label('שרת'),
                Tables\Columns\TextColumn::make('from_address')
                    ->label('אימייל שולח'),
                Tables\Columns\TextColumn::make('from_name')
                    ->label('שם שולח'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('עודכן')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMailSettings::class,
            'create' => Pages\CreateMailSetting::class,
            'edit' => Pages\EditMailSetting::class,
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
