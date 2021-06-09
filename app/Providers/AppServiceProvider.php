<?php

namespace App\Providers;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Model::unguard();

        Gate::define('viewMailcoach', function ($user = null) {
            return optional($user)->is_admin;
        });

        Flash::levels([
            'success' => 'success',
            'error' => 'error',
        ]);
    }
}
