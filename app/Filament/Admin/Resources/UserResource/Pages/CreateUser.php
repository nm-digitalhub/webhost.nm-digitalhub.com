<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Notifications\NewUserWelcomeNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    
    /**
     * Handle the data before creating the record
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate a random password if none provided
        if (empty($data['password'])) {
            $this->plainPassword = Str::password(12);
            $data['password'] = Hash::make($this->plainPassword);
        } else {
            $this->plainPassword = $data['password'];
        }
        
        return $data;
    }
    
    /**
     * Handle after the record was created
     */
    protected function afterCreate(): void
    {
        // Get the created user
        $user = $this->record;
        
        // Get form data
        $data = $this->data;
        
        // Send welcome email with password if toggled on
        if (($data['send_welcome_email'] ?? true) === true) {
            $user->notify(new NewUserWelcomeNotification($this->plainPassword));
            
            // Add notification
            \Filament\Notifications\Notification::make()
                ->title('אימייל ברוכים הבאים נשלח')
                ->body('נשלח אימייל ברוכים הבאים לכתובת: ' . $user->email)
                ->success()
                ->send();
        }
    }
}
