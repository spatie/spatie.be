<?php

use App\Docs\DocsImporter;
use Illuminate\Support\Facades\Storage;
use Tests\Docs\Support\FakeGitHubDocs;

beforeEach(function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    config()->set('docs.cache_store', 'array');
});

it('serves an image from the assets disk', function () {
    Storage::disk('docs-assets')->put('laravel-backup/v9/images/header.png', 'png contents');

    $response = $this->get('/docs/laravel-backup/v9/images/header.png');

    $response->assertOk();
    expect($response->streamedContent())->toBe('png contents');
});

it('returns a 404 for an image that does not exist', function () {
    $this->get('/docs/laravel-backup/v9/images/missing.png')->assertNotFound();
});

it('does not serve files outside of the repository', function () {
    Storage::disk('docs-assets')->put('laravel-backup/v9/images/header.png', 'png contents');

    $this->get('/docs/laravel-backup/v9/images/../../v9/images/header.png')->assertNotFound();
});

it('does not start a session when serving an image', function () {
    Storage::disk('docs-assets')->put('laravel-backup/v9/images/header.png', 'png contents');

    $response = $this->get('/docs/laravel-backup/v9/images/header.png');

    expect($response->headers->getCookies())->toBeEmpty();
});

it('redirects to the image in the bucket when the assets are stored in a bucket', function () {
    storeDiskInPublicBucket('docs-assets', 'docs');

    $response = $this->get('/docs/laravel-medialibrary/v9/images/header.jpg');

    $response
        ->assertMovedPermanently()
        ->assertRedirect('https://public-bucket.example.com/docs/laravel-medialibrary/v9/images/header.jpg')
        ->assertHeader('Cache-Control', 'max-age=86400, public')
        ->assertDontSee('data-og-image', escape: false);

    expect($response->headers->getCookies())->toBeEmpty();
});

it('encodes the path of the image in the bucket url', function () {
    storeDiskInPublicBucket('docs-assets', 'docs');

    $this
        ->get('/docs/laravel-backup/v9/images/my%20header%23.png')
        ->assertRedirect('https://public-bucket.example.com/docs/laravel-backup/v9/images/my%20header%23.png');
});

it('does not redirect to files outside of the repository in the bucket', function () {
    storeDiskInPublicBucket('docs-assets', 'docs');

    $this->get('/docs/laravel-backup/v9/images/%2E%2E/%2E%2E/%2E%2E/medialibrary/1/image.png')->assertNotFound();
});

it('still renders the imported docs pages', function () {
    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9', 'Welcome to the backup docs'));

    app(DocsImporter::class)->import([
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9'],
        'category' => 'Laravel',
    ]);

    $this->get('/docs/laravel-backup/v9/introduction')
        ->assertOk()
        ->assertSee('Welcome to the backup docs');

    $this->get('/docs/laravel-backup/v9/basic-usage/taking-backups')
        ->assertOk()
        ->assertSee('Run the backup command.');

    $this->get('/docs/laravel-backup')->assertRedirect('/docs/laravel-backup/v9/introduction');
});
