<?php

namespace App\Providers;

use App\Models\Insight;
use App\Models\Member;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('app_svg', function ($expression) {
            return "<?php echo app_svg({$expression}); ?>";
        });

        View::composer('front.pages.open-source.partials.insights', function ($view): void {
            $view->with('insights', Insight::getLatest());
        });

        View::composer('front.pages.home.partials.news', function ($view): void {
            $view->with('insights', Insight::getLatest());
        });

        View::composer('front.pages.about.partials.team', function ($view): void {
            $view->with('members', Member::orderBy('first_name')->get());
        });

        Blade::component('components.avatar', 'avatar');
        Blade::component('components.completionBadge', 'completion-badge');
        Blade::component('front.profile.components.purchase-assignment', 'purchase-assignment');

        Blade::component('front.pages.open-source.components.staggered-title', 'oss-staggered-title');
        Blade::component('front.pages.open-source.components.card', 'oss-card');
        Blade::component('front.pages.open-source.components.link-card', 'oss-link-card');
        Blade::component('front.pages.open-source.components.content', 'oss-content');
        Blade::component('front.pages.open-source.components.menu', 'oss-menu');
        Blade::component('front.pages.open-source.components.statistic', 'oss-statistic');

        Blade::component('front.pages.docs.components.banner', 'docs-banner');
    }
}
