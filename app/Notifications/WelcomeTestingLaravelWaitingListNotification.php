<?php

namespace App\Notifications;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeTestingLaravelWaitingListNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(Subscriber $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("You are now subscribed to the Testing Laravel waiting list")
            ->greeting('Hi!')
            ->line("Thank you for subscribing to the Testing Laravel waiting list. In the coming weeks we'll send you a couple of previews, and of course we'll notify you as soon as the course is available.")
            ->line('We would like to offer you this coupon code that grants you a 10% discount on all products in our store:')
            ->line('WAITING-FOR-TESTING-LARAVEL')
            ->action('Redeem the coupon on our store', route('products.index'))
            ->line("We are very excited to launch this course and can't wait to share our insights and knowledge with you.");
    }
}
