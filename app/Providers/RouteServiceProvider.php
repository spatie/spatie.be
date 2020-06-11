<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapAdminRoutes();

        $this->mapFrontRoutes();

        $this->mapApiRoutes();

        $this->mapRedirectsForOldSite();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'admin', 'auth.basic', 'spatieMembers'])
            ->group(base_path('routes/admin.php'));
    }

    protected function mapFrontRoutes()
    {
        Route::middleware(['web'])
            ->group(base_path('routes/front.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware(['api'])
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }

    protected function mapRedirectsForOldSite()
    {
        require base_path('routes/redirects.php');
    }
}
