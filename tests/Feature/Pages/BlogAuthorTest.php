<?php

use App\Models\Member;
use Illuminate\Support\Facades\Http;

function blogAuthorTestPost(string $title, string $slug, string $authorEmail): array
{
    return [
        'title' => $title,
        'slug' => $slug,
        'header_image' => null,
        'summary' => '',
        'authors' => [['name' => 'Author', 'email' => $authorEmail]],
        'content' => '',
        'published' => true,
        'date' => '2026-09-01',
        'updated_at' => '2026-09-01',
    ];
}

function fakeBlogAuthorTestPosts(array $posts): void
{
    Http::preventStrayRequests();

    Http::fake([
        'content.spatie.be/*' => Http::response([
            'data' => $posts,
            'meta' => ['last_page' => 1],
        ]),
    ]);
}

beforeEach(function () {
    $this->member = Member::factory()->create([
        'first_name' => 'Sebastian',
        'last_name' => 'De Deyne',
        'email' => 'sebastian@spatie.be',
    ]);
});

it('lists the posts of a member on their author page', function () {
    fakeBlogAuthorTestPosts([
        blogAuthorTestPost('Refactoring React', 'refactoring-react', 'sebastian@spatie.be'),
        blogAuthorTestPost('Writing PHP', 'writing-php', 'freek@spatie.be'),
    ]);

    $this
        ->get(route('blog.author', $this->member->author_slug))
        ->assertSuccessful()
        ->assertSee('Sebastian')
        ->assertSee('Refactoring React')
        ->assertDontSee('Writing PHP');
});

it('returns 404 for an unknown author or an author without posts', function (string $slug) {
    fakeBlogAuthorTestPosts([
        blogAuthorTestPost('Writing PHP', 'writing-php', 'freek@spatie.be'),
    ]);

    $this
        ->get(route('blog.author', $slug))
        ->assertNotFound();
})->with([
    'unknown author' => 'unknown',
    'author without posts' => 'sebastian-de-deyne',
]);

it('links post authors to their author page', function () {
    fakeBlogAuthorTestPosts([
        blogAuthorTestPost('Refactoring React', 'refactoring-react', 'sebastian@spatie.be'),
    ]);

    $authorPageUrl = route('blog.author', $this->member->author_slug);

    $this
        ->get(route('blog.show', 'refactoring-react'))
        ->assertSuccessful()
        ->assertSee("href=\"{$authorPageUrl}\"", false);
});
