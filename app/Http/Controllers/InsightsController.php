<?php

namespace App\Http\Controllers;

use App\Models\ExternalFeedItem;
use Illuminate\Http\Request;
use Spatie\ContentApi\ContentApi;
use Spatie\ContentApi\Data\Post;
use Spatie\Feed\FeedItem;

class InsightsController
{
    public function index(Request $request)
    {
        $insights = ContentApi::getPosts(
            product: 'ray',
            page: request('page', 1),
            perPage: 5,
            theme: 'nord',
        );

        if ($request->get('page', 1) === 1) {
            $highlight = $insights->first();

            unset($insights[0]);
        }

        $externalFeedItems = ExternalFeedItem::query()
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        return view('front.pages.insights.index', [
            'insights' => $insights,
            'highlight' => $highlight ?? null,
            'externalFeedItems' => $externalFeedItems,
        ]);
    }

    public function detail(string $slug)
    {
        $post = ContentApi::getPost('ray', $slug, theme: 'nord');

        if (! $post && is_numeric(explode('-', $slug)[0])) {
            $parts = explode('-', $slug);

            $parts = array_slice($parts, 1);

            return redirect(action([self::class, 'detail'], implode('-', $parts)), 301);
        }

        abort_if(is_null($post), 404);

        $otherPosts = ContentApi::getPosts('ray', 1, 3, theme: 'nord')
            ->filter(function (Post $otherPost) use ($post) {
                return $otherPost->slug !== $post->slug;
            })
            ->take(2);

        return view('front.pages.insights.show', [
            'post' => $post,
            'otherPosts' => $otherPosts,
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