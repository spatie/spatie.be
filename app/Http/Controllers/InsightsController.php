<?php

namespace App\Http\Controllers;

use Spatie\ContentApi\ContentApi;
use Spatie\ContentApi\Data\Post;
use Spatie\Feed\FeedItem;

class InsightsController
{
    public function index()
    {
        $posts = ContentApi::getPosts('ray', request('page', 1), theme: 'nord');

        if (request('page', 1)) {
            $firstPost = $posts->first();
            unset($posts[0]);
        }

        return view('front.pages.insights.index', [
            'posts' => $posts,
            'firstPost' => $firstPost ?? null,
        ]);
    }

    public function detail(string $slug)
    {
        $post = ContentApi::getPost('spatie', $slug, theme: 'nord');

        if (! $post && is_numeric(explode('-', $slug)[0])) {
            $parts = explode('-', $slug);

            $parts = array_slice($parts, 1);

            return redirect(action([self::class, 'detail'], implode('-', $parts)), 301);
        }

        abort_if(is_null($post), 404);

        return view('front.pages.insights.show', [
            'post' => $post,
        ]);
    }

    public static function getFeedItems()
    {
        return ContentApi::getPosts('spatie', 1, 10_000, theme: 'nord')->map(function (Post $post) {
            return FeedItem::create()
                ->id($post->slug)
                ->title($post->title)
                ->summary($post->summary)
                ->updated($post->updated_at)
                ->link(action([self::class, 'detail'], $post->slug))
                ->authorName($post->authors->first()?->name);
        });
    }
}
