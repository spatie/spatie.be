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
            ->line("Thank you for subscribing to the Front line PHP waiting list. In the coming weeks we'll send you a couple of previews, and of course we'll notify you as soon as Front Line PHP is available.")
            ->line('We would like to offer you this coupon code, which is valid for two weeks only, that grants you a 25% discount on all products in our store:')
            ->line('WAITING-FOR-FRONT-LINE-PHP')
            ->action('Redeem the coupon on our store', route('products.index'))
            ->line("We are very excited about PHP 8 and can't wait to share our insights and knowledge with you.");
    }
}
