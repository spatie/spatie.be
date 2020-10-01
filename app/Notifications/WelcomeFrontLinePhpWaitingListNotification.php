<?php

namespace App\Notifications;

use App\Http\Controllers\ProductsController;
use App\Models\License;
use App\Models\Subscriber;
use App\Models\User;
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
        return (new MailMessage)
            ->subject("Welcome")
            ->greeting('Hi!')
            ->action('Visit our little show', route('products.index'))
            ->line("Thank you!");
    }
}
