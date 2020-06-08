<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Gate::define('viewMailcoach', function ($user = null) {
            return optional($user)->is_admin;
        });
    }
}
