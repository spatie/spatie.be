<?php

namespace App\Domain\Shop\Notifications;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Http\Controllers\PurchasesController;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $purchaser, public Purchasable|Bundle $purchasable)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject("You've been assigned a purchase of {$this->purchasable->getFullTitle()}")
            ->greeting("Hi {$notifiable->name}!")
            ->line("{$this->purchaser->name} has assigned you a purchase of **{$this->purchasable->getFullTitle()}**.")
            ->action('Take a look', action(PurchasesController::class));
    }
}
