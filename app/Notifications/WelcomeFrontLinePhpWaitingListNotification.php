<?php

namespace App\Notifications;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeFrontLinePhpWaitingListNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(Subscriber $notifiable): MailMessage
    {
        info('sending welcome mail');

        return (new MailMessage)
            ->subject("Welcome")
            ->greeting('Hi!')
            ->action('Visit our little show', route('products.index'))
            ->line("Thank you!");
    }
}
