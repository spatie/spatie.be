<?php

namespace App\Providers;

use App\Listeners\ClearAdminGoogleLogin;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [ClearAdminGoogleLogin::class],
        Logout::class => [ClearAdminGoogleLogin::class],
        CurrentDeviceLogout::class => [ClearAdminGoogleLogin::class],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
