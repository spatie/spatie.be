<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Gate::define('viewMailcoach', function ($user = null) {
            dd('here');
            return optional($user)->is_admin;
        });
    }
}
