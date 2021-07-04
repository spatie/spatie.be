<?php

namespace App\Providers;

use App\Nova\Dashboards\Sales;
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
        Gate::define('viewNova', function ($user) {
            return $user->is_admin;
        });
    }

    protected function cards()
    {
        return [
            new NewUsers(),
            new VideoCompletions(),
        ];
    }

    protected function dashboards()
    {
        return [
            new Sales(),
        ];
    }

    public function tools()
    {
        return [];
    }

    public function register()
    {
        Nova::style('admin', public_path('nova.css'));
    }
}
