<?php

namespace App\Listeners;

use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class ClearAdminGoogleLogin
{
    public function handle(Login|Logout|CurrentDeviceLogout $event): void
    {
        if ($event->guard === 'web') {
            session()->forget('admin_google_login');
        }
    }
}
