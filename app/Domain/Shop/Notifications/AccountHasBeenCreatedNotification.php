<?php

namespace App\Domain\Shop\Notifications;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Http\Auth\Controllers\ResetPasswordController;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountHasBeenCreatedNotification extends Notification
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
        $token = resolve('auth.password.broker')->createToken($notifiable);

        return (new MailMessage())
            ->subject("Finish setting up your spatie.be account")
            ->greeting('Hi!')
            ->line("{$this->purchaser->name} has assigned you a purchase of **{$this->purchasable->getFullTitle()}**.")
            ->line("You will need to set a password for your account to get access to it.")
            ->action('Set password', action([ResetPasswordController::class, 'showResetForm'], ['token' => $token, 'email' => $notifiable->email]));
    }
}
