<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $sessionDriver = 'array';

        if (! app()->runningInConsole() && request()->segment(1) === 'admin') {
            $sessionDriver = 'file';
        }

        config()->set('session.driver', $sessionDriver);
    }
}
