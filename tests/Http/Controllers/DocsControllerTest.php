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

it('links the images of a docs page to the bucket when the assets are stored in a bucket', function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    config()->set('docs.cache_store', 'array');

    $introduction = implode("\n\n", [
        '![Header](/docs/laravel-backup/v9/images/header.png)',
        '<img src="/docs/laravel-backup/v9/images/my%20image.png">',
        '<img src="/docs/laravel-backup/v9/images/../../../medialibrary/1/image.png">',
        '<img src="/docs/laravel-medialibrary/v9/images/header.jpg">',
    ]);

    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9', $introduction));

    app(DocsImporter::class)->import([
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9'],
        'category' => 'Laravel',
    ]);

    storeDiskInPublicBucket('docs-assets', 'docs');

    $this
        ->get('/docs/laravel-backup/v9/introduction')
        ->assertOk()
        ->assertSee('src="https://public-bucket.example.com/docs/laravel-backup/v9/images/header.png"', escape: false)
        ->assertSee('src="https://public-bucket.example.com/docs/laravel-backup/v9/images/my%20image.png"', escape: false)
        ->assertSee('src="/docs/laravel-backup/v9/images/../../../medialibrary/1/image.png"', escape: false)
        ->assertSee('src="/docs/laravel-medialibrary/v9/images/header.jpg"', escape: false);
});

it('keeps the images of a docs page on the site when the assets are stored locally', function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    config()->set('docs.cache_store', 'array');

    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9', '![Header](/docs/laravel-backup/v9/images/header.png)'));

    app(DocsImporter::class)->import([
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9'],
        'category' => 'Laravel',
    ]);

    $this
        ->get('/docs/laravel-backup/v9/introduction')
        ->assertOk()
        ->assertSee('src="/docs/laravel-backup/v9/images/header.png"', escape: false);
});
