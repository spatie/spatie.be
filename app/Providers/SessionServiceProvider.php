<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $sessionDriver = 'array';

        if (! app()->runningInConsole() && request()->segment(1) === 'admin') {
            $sessionDriver = 'file';
        }

        config()->set('session.driver', $sessionDriver);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
