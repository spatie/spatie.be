<?php

namespace App\Providers;

use App\Models\ExternalFeedItem;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\ContentApi\ContentApi;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('app_svg', function ($expression) {
            return "<?php echo app_svg({$expression}); ?>";
        });

        View::composer('front.pages.home.partials.news', function ($view): void {
            try {
                $latestBlogPost = Cache::flexible('home.latestBlogPost', [60, 60 * 60], function () {
                    return ContentApi::getPosts(
                        product: 'spatie',
                        page: request('page', 1),
                        perPage: 1,
                    )->first();
                });
            } catch (Exception) {
            }

            $view->with('latestBlogPost', $latestBlogPost ?? null);
            $view->with('externalFeedItems', ExternalFeedItem::getLatest());
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
