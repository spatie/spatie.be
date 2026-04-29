<?php

namespace App\Providers;

use App\Models\ExternalFeedItem;
use App\Models\Member;
use Exception;
use Illuminate\Support\Collection;
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
            $blogPosts = collect();

            try {
                $blogPosts = Cache::flexible('home.blogPosts', [60, 60 * 60], function () {
                    return collect(ContentApi::getPosts(
                        product: 'spatie',
                        perPage: 12,
                    )->items());
                });
            } catch (Exception) {
            }

            $externalFeedItems = Cache::flexible('home.externalFeedItems', [60, 60 * 60], function () {
                return ExternalFeedItem::query()
                    ->orderBy('created_at', 'desc')
                    ->limit(24)
                    ->get();
            });

            $view->with('newsIntro', '');
            $view->with('newsItems', $this->getHomeNewsItems($blogPosts, $externalFeedItems));
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

    private function getHomeNewsItems(Collection $blogPosts, Collection $externalFeedItems): Collection
    {
        $items = $blogPosts
            ->map(function ($post) {
                $authorName = collect($post->authors ?? [])->first()?->name;

                return (object) [
                    'title' => $post->title,
                    'url' => route('blog.show', $post->slug),
                    'created_at' => $post->date,
                    'website' => 'spatie.be',
                    'is_external' => false,
                    'avatar_url' => $this->getAvatarUrlForAuthor($authorName),
                    'avatar_alt' => $authorName ? "{$authorName} avatar" : 'Spatie avatar',
                ];
            })
            ->concat($externalFeedItems->map(function (ExternalFeedItem $externalFeedItem) {
                $avatarFilename = $this->getAvatarFilenameForWebsite($externalFeedItem->website);

                return (object) [
                    'title' => $externalFeedItem->title,
                    'url' => $externalFeedItem->url,
                    'created_at' => $externalFeedItem->created_at,
                    'website' => $externalFeedItem->website,
                    'is_external' => true,
                    'avatar_url' => $avatarFilename ? asset("images/avatars/{$avatarFilename}") : null,
                    'avatar_alt' => $externalFeedItem->website . ' avatar',
                ];
            }))
            ->sortByDesc(fn (object $item) => $item->created_at->getTimestamp())
            ->values();

        $selectedItems = collect();
        $sourceCounts = [];

        foreach ($items as $item) {
            if (($sourceCounts[$item->website] ?? 0) >= 2) {
                continue;
            }

            $selectedItems->push($item);
            $sourceCounts[$item->website] = ($sourceCounts[$item->website] ?? 0) + 1;

            if ($selectedItems->count() === 6) {
                break;
            }
        }

        return $selectedItems;
    }

    private function getAvatarUrlForAuthor(?string $authorName): string
    {
        if (! $authorName) {
            return asset('images/avatars/alex.png');
        }

        return match (strtolower($authorName)) {
            'alex' => asset('images/avatars/alex.png'),
            'freek' => asset('images/avatars/freek.png'),
            'ruben' => asset('images/avatars/ruben.png'),
            'sebastian' => asset('images/avatars/seb.png'),
            'tim' => asset('images/avatars/tim.png'),
            default => asset('images/avatars/alex.png'),
        };
    }

    private function getAvatarFilenameForWebsite(?string $website): string
    {
        return match (strtolower($website ?? '')) {
            'flareapp.io' => 'ruben.png',
            'mailcoach.app' => 'freek.png',
            'rias.be' => 'tim.png',
            'sebastiandedeyne.com' => 'seb.png',
            default => 'alex.png',
        };
    }
}
