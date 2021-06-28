<?php

namespace App\Providers;

use App\Nova\Metrics\Earnings;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\PurchasesPerProduct;
use App\Nova\Metrics\PurchasesPerProductPerDay;
use App\Nova\Metrics\PurchasesPerProductPerMonth;
use App\Nova\Metrics\PurchasesPerPurchasablePerDay;
use App\Nova\Metrics\PurchasesPerPurchasablePerMonth;
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
            new Earnings(),
            new PurchasesPerProduct(),
            new VideoCompletions(),
            PurchasesPerProductPerDay::create(),
            PurchasesPerPurchasablePerDay::create(),
            PurchasesPerProductPerMonth::create(),
            PurchasesPerPurchasablePerMonth::create(),
        ];
    }

    protected function dashboards()
    {
        return [];
    }

    public function tools()
    {
        return [];
    }

    public function register()
    {
        Nova::style('admin', public_path('css/nova.css'));
    }
}
