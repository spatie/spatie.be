<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class MailcoachServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('viewMailcoach', function ($user = null) {
            return $user?->is_admin;
        });
    }
}
