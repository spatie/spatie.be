<?php

namespace App\Providers;

use App\Nova\Dashboards\Main;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\VideoCompletions;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function routes(): void
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    protected function gate(): void
    {
        Gate::define('viewNova', fn($user) => $user->is_admin);
    }

    public function register()
    {
        Nova::style('admin', public_path('nova.css'));
    }
}
