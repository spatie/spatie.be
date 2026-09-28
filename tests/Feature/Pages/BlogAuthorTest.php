<?php

use App\Models\Member;
use Illuminate\Support\Facades\Http;

function contentApiPost(string $title, string $slug, string $authorEmail): array
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

function fakeContentApiPosts(array $posts): void
{
    Http::fake([
        'content.spatie.be/*' => Http::response([
            'data' => $posts,
            'meta' => ['last_page' => 1],
        ]),
    ]);
}

it('lists the posts of a member on their author page', function () {
    $member = Member::factory()->create([
        'first_name' => 'Sebastian',
        'last_name' => 'De Deyne',
        'email' => 'sebastian@spatie.be',
        'github' => 'sebastiandedeyne',
    ]);

    fakeContentApiPosts([
        contentApiPost('Refactoring React', 'refactoring-react', 'sebastian@spatie.be'),
        contentApiPost('Writing PHP', 'writing-php', 'freek@spatie.be'),
    ]);

    $this
        ->get(route('blog.author', $member->author_slug))
        ->assertSuccessful()
        ->assertSee('Sebastian De Deyne')
        ->assertSee('https://github.com/sebastiandedeyne')
        ->assertSee('Refactoring React')
        ->assertDontSee('Writing PHP');
});

it('returns 404 for an unknown author', function () {
    Http::fake();

    $this
        ->get(route('blog.author', 'unknown'))
        ->assertNotFound();
});

it('links post authors to their author page', function () {
    $member = Member::factory()->create([
        'first_name' => 'Sebastian',
        'last_name' => 'De Deyne',
        'email' => 'sebastian@spatie.be',
    ]);

    fakeContentApiPosts([
        contentApiPost('Refactoring React', 'refactoring-react', 'sebastian@spatie.be'),
    ]);

    $this
        ->get(route('blog.show', 'refactoring-react'))
        ->assertSuccessful()
        ->assertSee(route('blog.author', $member->author_slug));
});
