<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\Sheets\Sheets;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        Route::bind('documentationPage', function ($path) {
            return $this->app->make(Sheets::class)
                    ->collection('docs')
                    ->get($path) ?? abort(404);
        });
    }

    public function map()
    {
        $this->mapAdminRoutes();

        $this->mapFrontRoutes();

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

    protected function mapRedirectsForOldSite()
    {
        require base_path('routes/redirects.php');
    }
}
