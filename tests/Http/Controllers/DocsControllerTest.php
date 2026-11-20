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

it('lists Rust docs in their own category and serves the configured version', function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    config()->set('docs.cache_store', 'array');

    $repository = collect(config('docs.repositories'))->firstWhere('name', 'rust-crawler');

    $files = [
        '_index.md' => "---\ntitle: v0.2\nslogan: Crawl the web using Rust\ngithubUrl: https://github.com/spatie/rust-crawler\nbranch: main\n---\n",
        'introduction.md' => "---\ntitle: Introduction\nweight: 1\n---\n\n[Setup](installation-setup.md)\n",
        'installation-setup.md' => "---\ntitle: Installation & setup\nweight: 2\n---\n\n```rust,no_run\nlet crawler = Crawler::new();\n```\n",
        'basic-usage/_index.md' => "---\ntitle: Basic usage\nweight: 3\n---\n",
        'basic-usage/first-crawl.md' => "---\ntitle: First crawl\nweight: 1\n---\n\n[Setup](../installation-setup.md#library)\n[Next](next.md?example=1#code)\n[Source](https://github.com/spatie/rust-crawler/blob/main/README.md)\n",
    ];

    $gitHub = FakeGitHubDocs::make()->branch('spatie/rust-crawler', 'main', $files);

    app(DocsImporter::class)->import($repository);

    foreach (['laravel-backup', 'crawler', 'image'] as $name) {
        $phpRepository = collect(config('docs.repositories'))->firstWhere('name', $name);
        $version = $phpRepository['branches']['main'];
        $gitHub->branch($phpRepository['repository'], 'main', FakeGitHubDocs::docsForVersion($version));
        $phpRepository['branches'] = ['main' => $version];
        app(DocsImporter::class)->import($phpRepository);
    }

    $this->get('/docs')
        ->assertOk()
        ->assertSeeInOrder(['Laravel packages', 'laravel-backup', 'PHP packages', 'crawler', 'image', 'Rust packages', 'rust-crawler', 'Other packages'])
        ->assertSee('id="rust"', escape: false)
        ->assertSee('Crawl the web using Rust')
        ->assertDontSee('image-optimizer-rust')
        ->assertDontSee('temporary-directory-rust')
        ->assertSee('href="'.url('/docs/rust-crawler').'"', escape: false);

    $this->get('/docs/rust-crawler')
        ->assertRedirect('/docs/rust-crawler/v0.2/introduction');

    $this->get('/docs/rust-crawler/v0.2/introduction')
        ->assertOk()
        ->assertSee('href="installation-setup"', escape: false);

    $this->get('/docs/rust-crawler/v0.2/installation-setup')
        ->assertOk()
        ->assertSee('let crawler = Crawler::new();');

    $this->get('/docs/rust-crawler/v0.2/basic-usage/first-crawl')
        ->assertOk()
        ->assertSee('href="../installation-setup#library"', escape: false)
        ->assertSee('href="next?example=1#code"', escape: false)
        ->assertSee('href="https://github.com/spatie/rust-crawler/blob/main/README.md"', escape: false);
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
        ->assertHeader('Link', '<'.url('/docs/laravel-backup/v9/basic-usage/taking-backups.md').'>; rel="alternate"; type="text/markdown"')
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
        ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8')
        ->assertHeaderMissing('Content-Signal');
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
