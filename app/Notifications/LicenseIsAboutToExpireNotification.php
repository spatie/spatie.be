<?php

namespace App\Notifications;

use App\Http\Controllers\ProductsController;
use App\Models\License;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseIsAboutToExpireNotification extends Notification
{
    use Queueable;

    private License $license;

    public function __construct(License $license)
    {
        $this->license = $license;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        $name = $this->license->getName();

        $siteUrl = url('/');

        return (new MailMessage)
            ->subject("Your {$name} license is about to expire")
            ->greeting('Hi!')
            ->line("Your {$name} license expires on {$this->license->expires_at->format('Y-m-d')}")
            ->line("Go to your license overview on the [spatie.be]({$siteUrl}) site to renew the license and continue receiving updates")
            ->action('License overview', action([ProductsController::class, 'show'], $this->license->purchasable->product))
            ->line("Thank you for using {$this->license->purchasable->product->title}!");
    }
}
