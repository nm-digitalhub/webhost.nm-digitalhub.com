<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'ניהול משתמשים';

    protected static ?string $modelLabel = 'משתמש';

    protected static ?string $pluralModelLabel = 'משתמשים';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('שם')->required(),
                Forms\Components\TextInput::make('email')->label('אימייל')->email()->required(),
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('סיסמה')
                            ->password()
                            ->required(fn ($record) => $record === null)
                            ->minLength(8)
                            ->dehydrateStateUsing(fn ($state) => empty($state) ? null : \Illuminate\Support\Facades\Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->hiddenOn('edit'),

                        Forms\Components\Toggle::make('send_welcome_email')
                            ->label('שלח אימייל ברוכים הבאים')
                            ->helperText('שלח אימייל למשתמש עם פרטי ההתחברות')
                            ->default(true)
                            ->hiddenOn('edit'),
                    ]),

                Forms\Components\Select::make('roles')
                    ->label('תפקידים')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('שם')
                    ->sortable()
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('email')
                    ->label('אימייל')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('הועתק ללוח')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('תפקידים')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'super-admin' => 'danger',
                        'admin' => 'warning',
                        'client' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => __($state))
                    ->limit(3),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('תאריך הרשמה')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('last_login_at')
                    ->label('התחברות אחרונה')
                    ->getStateUsing(fn (User $record) => $record->last_login_at ?? null)
                    ->formatStateUsing(fn ($state) => $state ? $state->diffForHumans() : 'לא התחבר/ה')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->toggleable(true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->label('סנן לפי תפקיד')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('created_at')
                    ->label('נרשם בתאריך')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('מתאריך'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('עד תאריך'),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when(
                            $data['created_from'] ?? null,
                            fn ($query, $date) => $query->whereDate('created_at', '>=', $date)
                        )
                        ->when(
                            $data['created_until'] ?? null,
                            fn ($query, $date) => $query->whereDate('created_at', '<=', $date)
                        )),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),

                Tables\Actions\EditAction::make()
                    ->color('warning'),

                Tables\Actions\Action::make('resend_welcome')
                    ->label('שלח פרטי התחברות')
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->action(function (User $record) {
                        // Generate a new password
                        $plainPassword = \Illuminate\Support\Str::password(12);
                        $record->password = \Illuminate\Support\Facades\Hash::make($plainPassword);
                        $record->save();

                        // Send welcome email
                        $record->notify(new \App\Notifications\NewUserWelcomeNotification($plainPassword));

                        \Filament\Notifications\Notification::make()
                            ->title('אימייל ברוכים הבאים נשלח')
                            ->body('נשלח אימייל ברוכים הבאים לכתובת: '.$record->email)
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalDescription('פעולה זו תיצור סיסמה חדשה ותשלח אימייל ברוכים הבאים למשתמש. האם אתה בטוח?')
                    ->modalSubmitActionLabel('שלח אימייל'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('assign_role')
                        ->label('שיוך תפקיד')
                        ->icon('heroicon-o-user-group')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('role_id')
                                ->label('תפקיד')
                                ->options(Role::pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data) {
                            $role = Role::find($data['role_id']);

                            foreach ($records as $record) {
                                $record->assignRole($role);
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('התפקיד הוקצה בהצלחה')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100])
            ->poll('30s');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
