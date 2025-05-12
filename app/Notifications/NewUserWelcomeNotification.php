<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\MailTemplate;
use App\Services\Mail\MailTemplateManager;
use Illuminate\Support\Facades\App;

class NewUserWelcomeNotification extends Notification
{
    use Queueable;

    protected $plainPassword;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Get the current locale
        $lang = App::getLocale();
        
        // Find the template
        $template = MailTemplate::findTemplate('user_welcome', $lang);
        
        if ($template) {
            // Add password to data for template
            $additionalData = [
                'password' => $this->plainPassword
            ];
            
            // Render the template
            $rendered = MailTemplateManager::render($template, $notifiable, $additionalData);
            
            return (new MailMessage)
                ->subject($rendered['subject'])
                ->view('emails.template', [
                    'content' => $rendered['body']
                ]);
        }
        
        // Fallback if no template is found
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your account has been created successfully.')
            ->line('Email: ' . $notifiable->email)
            ->line('Password: ' . $this->plainPassword)
            ->action('Login Now', url('/login'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'password' => $this->plainPassword,
            'email' => $notifiable->email,
        ];
    }
}
