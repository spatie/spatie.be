<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function map()
    {
        $this->mapAdminRoutes();

        $this->mapWebRoutes();
        
        $this->mapRedirectsForOldSite();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'admin', 'auth.basic'])
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/admin.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'cacheResponse'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapRedirectsForOldSite()
    {
        collect(['en', 'nl'])->each(function (string $locale) {
            Route::prefix($locale)->group(function() {
                Route::redirect('/', '/');

                Route::prefix('opensource')->group(function() {
                    Route::redirect('/', 'open-source');
                    Route::redirect('php', 'open-source/packages');
                    Route::redirect('laravel', 'open-source/packages');
                    Route::redirect('javascript', 'open-source/packages');
                    Route::redirect('postcards', 'open-source/postcards');
                });

                Route::redirect('team', 'about-us');
                Route::redirect('disclaimer', 'disclaimer');
                Route::redirect('stage', 'vacancies/internships');
            });
        });
    }
}
