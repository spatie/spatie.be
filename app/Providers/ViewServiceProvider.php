<?php

namespace App\Providers;

use App\Models\Insight;
use App\Models\Member;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('svg', function ($expression) {
            return "<?php echo svg({$expression}); ?>";
        });

        View::composer('pages.open-source.partials.insights', function ($view) {
            $view->with('insights', Insight::getLatest());
        });

        View::composer('pages.home.partials.news', function ($view) {
            $view->with('insights', Insight::getLatest());
        });

        View::composer('pages.about.partials.team', function ($view) {
            $view->with('members', Member::orderBy('first_name')->get());
        });
    }
}
