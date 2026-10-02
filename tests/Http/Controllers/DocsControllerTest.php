<?php

namespace Http\Controllers;

use App\Docs\DocsImporter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\Docs\Support\FakeGitHubDocs;

it('can load the docs', function () {
    $this
        ->get(route('docs'))
        ->assertOk()
        ->assertSee('lighthouse-php')
        ->assertSee('laravel-comments')
        ->assertSee('laravel-backup')
        ->assertSee('laravel-data')
    ;
});

it('shows a docs page while only loading the docs of its repository', function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    config()->set('docs.cache_store', 'array');

    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9'));

    app(DocsImporter::class)->import([
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9'],
        'category' => 'Laravel',
    ]);

    $this
        ->get('/docs/laravel-backup/v9/basic-usage/taking-backups')
        ->assertOk()
        ->assertSee('Taking backups')
        ->assertSee('Run the backup command.')
        ->assertDontSee('Introduction text');

    expect(Cache::store('array')->has('docs.pages.laravel-medialibrary'))->toBeFalse();
});

it('handles a markdown head request for a docs page', function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    config()->set('docs.cache_store', 'array');

    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9'));

    app(DocsImporter::class)->import([
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9'],
        'category' => 'Laravel',
    ]);

    $this
        ->call('HEAD', '/docs/laravel-backup/v9/basic-usage/taking-backups', server: ['HTTP_ACCEPT' => 'text/markdown'])
        ->assertOk()
        ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
});
