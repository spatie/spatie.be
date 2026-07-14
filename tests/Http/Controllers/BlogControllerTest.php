<?php

namespace Http\Controllers;

use Illuminate\Support\Facades\Http;

function fakeBlogPost(int $number): array
{
    return [
        'title' => "Post {$number} title",
        'slug' => "post-{$number}",
        'header_image' => null,
        'header_image_presets' => [],
        'og_image' => null,
        'summary' => "<p>Summary of post {$number}</p>",
        'authors' => [],
        'tags' => [],
        'content' => "<p>Content of post {$number}</p>",
        'published' => true,
        'date' => '2026-01-01',
        'updated_at' => '2026-01-01T00:00:00+00:00',
    ];
}

beforeEach(function () {
    // 45 posts, 20 per page: pages 1 and 2 are full, page 3 has 5 posts
    Http::fake(function ($request) {
        parse_str(parse_url($request->url(), PHP_URL_QUERY) ?: '', $query);

        $page = (int) ($query['page'] ?? 1);
        $perPage = (int) ($query['limit'] ?? 20);

        $posts = collect(range(1, 45))
            ->forPage($page, $perPage)
            ->map(fn (int $number) => fakeBlogPost($number))
            ->values();

        return Http::response([
            'data' => $posts->all(),
            'meta' => ['last_page' => 3],
        ]);
    });
});

it('links to the next page of the archive from the blog index', function () {
    $this
        ->get(route('blog'))
        ->assertOk()
        ->assertSee('Latest post')
        ->assertSee('Post 1 title')
        ->assertSee('blog/all?page=2');
});

it('ignores the page parameter on the blog index', function () {
    $this
        ->get(route('blog', ['page' => 2]))
        ->assertOk()
        ->assertSee('Post 1 title')
        ->assertSee('blog/all?page=2');
});

it('shows the next page of posts on the archive', function () {
    $this
        ->get(route('blog.all', ['page' => 2]))
        ->assertOk()
        ->assertDontSee('Latest post')
        ->assertSee('Post 21 title')
        ->assertSee('blog/all?page=3');
});

it('only highlights the latest post on the first page of the archive', function () {
    $this
        ->get(route('blog.all'))
        ->assertOk()
        ->assertSee('Latest post');
});

it('hides the view more link on the last page of the archive', function () {
    $this
        ->get(route('blog.all', ['page' => 3]))
        ->assertOk()
        ->assertSee('Post 45 title')
        ->assertDontSee('View more');
});

it('gracefully handles invalid page parameters', function (mixed $page) {
    $this
        ->get(route('blog.all', ['page' => $page]))
        ->assertOk()
        ->assertSee('Post 1 title');
})->with([
    'non-numeric' => 'abc',
    'array' => [['1']],
    'negative' => -5,
    'zero' => 0,
]);
