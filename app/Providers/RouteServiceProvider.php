<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapAdminRoutes();

        $this->mapWebRoutes();

        $this->mapRedirectsForOldSite();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'admin', 'auth.basic'])
            ->group(base_path('routes/admin.php'));
    }

    protected function mapWebRoutes()
    {
        // Route::middleware(['web', 'cacheResponse'])
        Route::middleware(['web'])
            ->group(base_path('routes/web.php'));
    }

    protected function mapRedirectsForOldSite()
    {
        require base_path('routes/redirects.php');
    }
}
