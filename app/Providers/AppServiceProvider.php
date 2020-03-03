<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Horizon::auth(function () {
            if (app()->environment('local')) {
                return true;
            }

            return auth()->check();
        });

        Request::macro('isAdmin', function (Request $request) {
            return $request->segment(1) === 'admin';
        });
    }
}
