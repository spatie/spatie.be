<?php

namespace App\Http\Controllers;

use App\Models\ExternalFeedItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Spatie\ContentApi\ContentApi;
use Spatie\ContentApi\Data\Post;
use Spatie\Feed\FeedItem;

class InsightsController
{
    public function index(): View
    {
        $insights = self::getPosts(5);
        $highlight = $insights->first();
        unset($insights[0]);

        $externalFeedItems = ExternalFeedItem::query()
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        return view('front.pages.insights.index', [
            'insights' => $insights,
            'highlight' => $highlight ?? null,
            'externalFeedItems' => $externalFeedItems,
        ]);
    }

    public function all(): View
    {
        $insights = self::getPosts();

        $highlight = $insights->first();

        unset($insights[0]);

        return view('front.pages.insights.index', [
            'insights' => $insights,
            'highlight' => $highlight ?? null,
        ]);
    }

    public function detail(string $slug): View|RedirectResponse
    {
        $post = self::getPost($slug);

        if (! $post && is_numeric(explode('-', $slug)[0])) {
            $parts = explode('-', $slug);

            $parts = array_slice($parts, 1);

            return redirect(action([self::class, 'detail'], implode('-', $parts)), 301);
        }

        abort_if(is_null($post), 404);

        $content = $this->replaceComponents($post->content);

        $otherPosts = self::getPosts()
            ->filter(function (Post $otherPost) use ($post) {
                return $otherPost->slug !== $post->slug;
            })
            ->take(2);

        return view('front.pages.insights.show', [
            'post' => $post,
            'content' => $content,
            'otherPosts' => $otherPosts,
        ]);
    }

    public static function getFeedItems(): Paginator
    {
        return self::getPosts()->map(function (Post $post) {
            return FeedItem::create()
                ->id($post->slug)
                ->title($post->title)
                ->summary($post->summary)
                ->updated($post->updated_at)
                ->link(action([self::class, 'detail'], $post->slug))
                ->authorName($post->authors->first()?->name);
        });
    }

    private static function getPost(string $slug): ?Post
    {
        return ContentApi::getPost('spatie', $slug, theme: 'github-light');
    }

    private static function getPosts(int $perPage = 100): Paginator
    {
        return ContentApi::getPosts(
            product: 'spatie',
            page: request('page', 1),
            perPage: $perPage,
            theme: 'github-light',
        );
    }

    private function replaceComponents(string $content): string
    {
        preg_match_all('/\[\[\[([^\n\[]*)]]]/', $content, $matches);

        foreach ($matches[1] as $index => $match) {
            $definition = explode(':', $match);

            $method = "render" . ucfirst($definition[0]);
            if (! method_exists($this, $method)) {
                continue;
            }

            $component = $this->$method($definition[1] ?? null);
            $content = str_replace($matches[0][$index], $component, $content);
        }

        return $content;
    }

    private function renderBanner(?string $type): string
    {
        $props = [
            'ref' => 'insights',
            'class' => 'my-6',
            'thin' => true,
        ];

        if (! $type || ! file_exists(base_path("resources/views/components/banners/{$type}.blade.php"))) {
            return Blade::render('components.banners.randomBanner', $props);
        }

        return Blade::render("components.banners.{$type}", $props);
    }

    private function renderLink(?string $slug): string
    {
        if (! $slug) {
            return '';
        }

        $post = self::getPost($slug);

        if (! $post) {
            return '';
        }

        return Blade::render("components.insights.list-item", [
            'insight' => $post,
            'border' => true,
            //'class' => '-mx-12',
        ]);
    }
}
