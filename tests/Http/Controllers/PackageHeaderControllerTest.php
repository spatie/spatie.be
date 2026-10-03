<?php

use App\Models\Repository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('medialibrary');
});

it('serves the github header image from the media library disk', function () {
    $repository = Repository::factory()->create(['name' => 'laravel-backup']);

    $repository
        ->addMedia(UploadedFile::fake()->image('image.png', 830, 190))
        ->usingFileName('image.webp')
        ->toMediaCollection('github-header-dark');

    $response = $this->get('packages/header/laravel-backup/html/dark.webp');

    $response
        ->assertOk()
        ->assertHeader('Content-Type', 'image/png');

    expect($response->streamedContent())->not->toBeEmpty();
});

it('does not start a session when serving the github header image', function () {
    $repository = Repository::factory()->create(['name' => 'laravel-backup']);

    $repository
        ->addMedia(UploadedFile::fake()->image('image.png', 830, 190))
        ->usingFileName('image.webp')
        ->toMediaCollection('github-header-dark');

    $response = $this->get('packages/header/laravel-backup/html/dark.webp');

    expect($response->headers->getCookies())->toBeEmpty();
});

it('redirects to the github header image in the bucket when the media library is stored in a bucket', function () {
    $repository = Repository::factory()->create(['name' => 'laravel-backup']);

    $media = $repository
        ->addMedia(UploadedFile::fake()->image('image.png', 830, 190))
        ->usingFileName('image.webp')
        ->toMediaCollection('github-header-light');

    storeDiskInPublicBucket('medialibrary', 'medialibrary');

    $response = $this->get('packages/header/laravel-backup/html/light.webp');

    $response
        ->assertStatus(302)
        ->assertRedirect("https://public-bucket.example.com/medialibrary/{$media->id}/image.webp")
        ->assertHeader('Cache-Control', 'max-age=3600, public')
        ->assertDontSee('data-og-image', escape: false);

    expect($response->headers->getCookies())->toBeEmpty();
});

it('returns a 404 when a repository has no github header', function () {
    Repository::factory()->create(['name' => 'laravel-backup']);

    $this->get('packages/header/laravel-backup/html/dark.webp')->assertNotFound();
});
