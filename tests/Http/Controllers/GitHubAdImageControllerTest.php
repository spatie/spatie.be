<?php

use App\Models\Repository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('github_ads');
});

it('serves the full image with its actual mime type and shared cache headers without cookies', function () {
    $repository = Repository::factory()->create(['name' => 'laravel-permission']);
    $image = UploadedFile::fake()->image('ad.png', 419, 100);

    Storage::disk('github_ads')->put($repository->gitHubAdImagePath(), $image->get());

    $response = $this->get('/github-ad-image/laravel-permission.jpg');

    $response
        ->assertOk()
        ->assertHeader('Content-Type', 'image/png')
        ->assertHeader('Cache-Control', 'max-age=120, public')
        ->assertHeader('Cloudflare-CDN-Cache-Control', 'public, max-age=86400')
        ->assertHeaderMissing('Location');

    expect($response->streamedContent())->toBe($image->get())
        ->and($response->headers->getCookies())->toBeEmpty();
});

it('serves the updated image at the same url on the next origin request', function () {
    $repository = Repository::factory()->create(['name' => 'laravel-permission']);
    $firstImage = UploadedFile::fake()->image('first.png', 419, 100);
    $secondImage = UploadedFile::fake()->image('second.png', 419, 200);

    Storage::disk('github_ads')->put($repository->gitHubAdImagePath(), $firstImage->get());

    expect($this->get('/github-ad-image/laravel-permission.jpg')->streamedContent())->toBe($firstImage->get());

    Storage::disk('github_ads')->put($repository->gitHubAdImagePath(), $secondImage->get());

    expect($this->get('/github-ad-image/laravel-permission.jpg')->streamedContent())->toBe($secondImage->get());
});

it('does not expose a file that does not belong to a repository', function () {
    Storage::disk('github_ads')->put('original.jpg', 'original ad');

    $this->get('/github-ad-image/original.jpg')
        ->assertNotFound()
        ->assertHeader('Cache-Control', 'no-store, private');
});

it('does not cache the error for a repository without an image', function () {
    Repository::factory()->create(['name' => 'laravel-permission']);

    $response = $this->get('/github-ad-image/laravel-permission.jpg');

    $response
        ->assertNotFound()
        ->assertHeader('Cache-Control', 'no-store, private');

    expect($response->headers->getCookies())->toBeEmpty();
});
