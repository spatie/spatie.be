<?php

use App\Livewire\SearchDocsComponent;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Spatie\SiteSearch\Models\SiteSearchConfig;

beforeEach(function () {
    SiteSearchConfig::create([
        'name' => 'docs',
        'index_base_name' => 'docs',
        'index_name' => 'docs-test',
        'crawl_url' => 'https://spatie.be/docs',
        'enabled' => true,
    ]);

    foreach ([
        ['question', 'Questions about conversions', 'Ask a question about conversions', 'image', 'v3'],
        ['resize', 'Image resizing', 'Resize images automatically', 'image', 'v3'],
        ['old-resize', 'Old image resizing', 'Resize images automatically', 'image', 'v2'],
        ['other-resize', 'Media resizing', 'Resize images automatically', 'laravel-medialibrary', 'v3'],
    ] as [$id, $title, $entry, $repo, $version]) {
        DB::table('site_search_documents')->insert([
            'index_name' => 'docs-test',
            'document_id' => $id,
            'url' => "https://spatie.be/docs/{$repo}/{$version}/{$id}",
            'page_title' => $title,
            'entry' => $entry,
            'extra' => json_encode(compact('repo', 'version')),
        ]);
    }
});

it('does not expand short words into broad wildcard searches', function () {
    Livewire::test(SearchDocsComponent::class)
        ->set('currentUrl', 'https://spatie.be/docs/image/v3/introduction')
        ->set('query', 'I ask you a question please?')
        ->assertSee('Questions about conversions')
        ->assertDontSee('Image resizing');
});

it('finds partial words within the current repository and version', function () {
    $queries = [];

    DB::listen(function (QueryExecuted $event) use (&$queries) {
        if (str_contains($event->sql, 'MATCH(')) {
            $queries[] = $event->sql;
        }
    });

    Livewire::test(SearchDocsComponent::class)
        ->set('currentUrl', 'https://spatie.be/docs/image/v3/introduction')
        ->set('query', 'resiz')
        ->assertSee('Image resizing')
        ->assertDontSee('Old image resizing')
        ->assertDontSee('Media resizing');

    expect($queries)->toHaveCount(2);

    foreach ($queries as $query) {
        expect($query)->toContain('MAX_EXECUTION_TIME(1000)');
    }
});

it('does not query the full-text index for invalid search terms', function (string $query) {
    $searches = 0;

    DB::listen(function (QueryExecuted $event) use (&$searches) {
        if (str_contains($event->sql, 'MATCH(')) {
            $searches++;
        }
    });

    Livewire::test(SearchDocsComponent::class)
        ->set('currentUrl', 'https://spatie.be/docs/image/v3/introduction')
        ->set('query', $query)
        ->assertOk();

    expect($searches)->toBe(0);
})->with([
    'short words' => 'a i an',
    'punctuation' => '*** / @ <>',
    'too long' => str_repeat('resize ', 30),
]);

it('limits searches per visitor and allows them again after a minute', function () {
    $this->freezeTime();

    RateLimiter::increment('docs-search:127.0.0.1', amount: 59);

    $component = Livewire::test(SearchDocsComponent::class)
        ->set('currentUrl', 'https://spatie.be/docs/image/v3/introduction')
        ->set('query', 'resiz')
        ->assertSee('Image resizing');

    $component->set('query', 'resize')
        ->assertSee('Too many searches. Please try again in a minute.')
        ->assertDontSee('Image resizing');

    $this->travel(61)->seconds();

    $component->set('query', 'resizing')
        ->assertHasNoErrors()
        ->assertSee('Image resizing');
});

it('shows a useful message when MySQL cancels a slow search', function () {
    DB::connection()->beforeExecuting(function (string $query) {
        if (str_contains($query, 'MATCH(')) {
            DB::select('SELECT /*+ MAX_EXECUTION_TIME(1) */ id, SLEEP(0.05) FROM site_search_documents LIMIT 2');
        }
    });

    Livewire::test(SearchDocsComponent::class)
        ->set('currentUrl', 'https://spatie.be/docs/image/v3/introduction')
        ->set('query', 'resize')
        ->assertSee('Search took too long. Try more specific terms.')
        ->assertDontSee('No results found');
});
