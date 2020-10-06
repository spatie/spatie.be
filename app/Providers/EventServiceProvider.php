<?php

namespace App\Providers;

use App\Listeners\SendCoupon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\Mailcoach\Events\SubscribedEvent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SubscribedEvent::class => [
            SendCoupon::class,
        ],
    ];
}
