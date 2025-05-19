<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestSmtpNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('בדיקת SMTP - NM-DigitalHUB')
            ->greeting('שלום '.$notifiable->name)
            ->line('זהו מייל בדיקה מהמערכת NM-DigitalHUB.')
            ->line('אם קיבלת מייל זה – ההגדרות שלך תקינות!')
            ->line('תודה, צוות NM-DigitalHUB');
    }
}
