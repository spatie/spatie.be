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
        return (new MailMessage)
            ->subject("You are now subscribed to the Front Line PHP waiting list")
            ->greeting('Hi!')
            ->line("Thank you for subscribing to the Front line PHP waiting list. We are very exciting about PHP 8 and can't wait to share our insights and knowledge with you.")
            ->line('We would like to offer you this coupon code, that grants your a 25% discount on all products in our store:')
            ->line('WAITING-FOR-FRONT-LINE_PHP')
            ->action('Visit our store', route('products.index'));
    }
}
