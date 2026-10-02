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

    $response->assertOk();

    expect($response->streamedContent())->not->toBeEmpty();
});

it('returns a 404 when a repository has no github header', function () {
    Repository::factory()->create(['name' => 'laravel-backup']);

    $this->get('packages/header/laravel-backup/html/dark.webp')->assertNotFound();
});
