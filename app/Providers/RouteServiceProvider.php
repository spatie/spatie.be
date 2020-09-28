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
        $this->mapWebRoutes();

        $this->mapApiRoutes();

        $this->mapRedirectsForOldSite();
    }

    protected function mapWebRoutes()
    {
        Route::sesFeedback('ses-feedback');

        Route::middleware(['web'])
            ->group(base_path('routes/web.php'));
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
