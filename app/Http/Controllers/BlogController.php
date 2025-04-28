<?php

namespace App\Http\Controllers;

use App\Models\ExternalFeedItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Spatie\ContentApi\ContentApi;
use Spatie\ContentApi\Data\Post;
use Spatie\Feed\FeedItem;

class BlogController
{
    public function index(): View
    {
        $posts = self::getPosts(20);
        $highlight = $posts->first();
        unset($posts[0]);

        $externalFeedItems = ExternalFeedItem::query()
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        return view('front.pages.blog.index', [
            'posts' => $posts,
            'highlight' => $highlight ?? null,
            'externalFeedItems' => $externalFeedItems,
        ]);
    }

    public function all(): View
    {
        $posts = self::getPosts();

        $highlight = $posts->first();

        unset($posts[0]);

        return view('front.pages.blog.index', [
            'posts' => $posts,
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

        return view('front.pages.blog.show', [
            'post' => $post,
            'content' => $content,
            'otherPosts' => $otherPosts,
        ]);
    }

    public static function getFeedItems(): Collection
    {
        return self::getPosts()
            ->map(function (Post $post) {
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
        return ContentApi::getPost(
            product: 'spatie',
            slug: $slug,
            theme: 'github-light',
        );
    }

    private static function getPosts(int $perPage = 20): Paginator
    {
        return ContentApi::getPosts(
            product: 'spatie',
            page: request('page', 1),
            perPage: $perPage,
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
            'ref' => 'posts',
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

        return Blade::render("components.posts.list-item", [
            'insight' => $post,
            'border' => true,
        ]);
    }
}
