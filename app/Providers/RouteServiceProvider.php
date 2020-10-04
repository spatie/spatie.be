<?php

namespace App\Providers;

use App\Models\Repository;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\Sheets\Sheets;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->registerRouteBindings();
    }

    protected function registerRouteBindings(): void
    {
        Route::bind('documentationPage', function (string $path) {
            return $this->app->make(Sheets::class)
                    ->collection('docs')
                    ->get($path) ?? abort(404);
        });

        Route::bind('repository', function (string $repositoryName) {
            return Repository::where('name', $repositoryName)->first() ?? new Repository();
        });
    }

    public function map()
    {
        $this
            ->mapWebRoutes()
            ->mapApiRoutes()
            ->mapRedirectsForOldSite();
    }

    protected function mapWebRoutes(): self
    {
        Route::sesFeedback('ses-feedback');

        Route::middleware(['web'])
            ->group(base_path('routes/web.php'));

        return $this;
    }

    protected function mapApiRoutes(): self
    {
        Route::middleware(['api'])
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        return $this;
    }

    protected function mapRedirectsForOldSite(): self
    {
        require base_path('routes/redirects.php');

        return $this;
    }
}
