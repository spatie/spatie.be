<?php

namespace App\Domain\Shop\Notifications;

use App\Domain\Shop\Models\License;
use App\Http\Controllers\ProductsController;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseExpiredNotification extends Notification
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

        $upgradeReason = "If you want to keep receiving updates, go to the license overview on the [spatie.be]({$siteUrl}) site to renew the license.";

        if ($this->license->concernsRay()) {
$upgradeReason = "If you want to keep using Ray, go to the license overview on the [spatie.be]({$siteUrl}) site to renew the license.";
        }

        return (new MailMessage)
            ->subject("Your {$name} license has expired")
            ->greeting('Hi!')
            ->line("Just a reminder to inform you that your {$name} license has expired.")
            ->line($upgradeReason)
            ->line(Markdown::parse($this->license->assignment->purchasable->renewal_mail_incentive))
            ->action('Renew now', route('purchases'))
            ->line("Thank you for using {$this->license->assignment->purchasable->product->title}!");
    }
}
