<?php

namespace App\Domain\Shop\Notifications;

use App\Domain\Shop\Models\License;
use App\Http\Controllers\ProductsController;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseExpiredSecondNotification extends Notification
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
            ->subject("Your {$name} license has expired")
            ->greeting('Hi again!')
            ->line("A quick -and last- reminder to tell you that your {$name} license has expired now.")
            ->line("At this point, you won't be receiving future updates for {$name}.")
            ->line("You can visit the license overview on the [spatie.be]({$siteUrl}) site anytime to reactivate updates.")
            ->line(Markdown::parse($this->license->purchasable->renewal_mail_incentive))
            ->action('Renew now', action([ProductsController::class, 'show'], $this->license->purchasable->product))
            ->line("Thank you for using {$this->license->purchasable->product->title}!");
    }
}
