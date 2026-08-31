<?php

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('github_ads');

    $this->migration = require database_path('migrations/2026_08_31_100000_add_banner_component_to_ads_table.php');
});

it('links ads that are named after their banner', function () {
    $flare = Ad::factory()->create(['name' => 'Flare', 'banner_component' => null]);
    $mailcoach = Ad::factory()->create(['name' => 'Mailcoach', 'banner_component' => null]);
    $blackFriday = Ad::factory()->create(['name' => 'Black Friday', 'banner_component' => null]);

    $this->migration->up();

    expect($flare->fresh()->banner_component)->toBe('flare')
        ->and($mailcoach->fresh()->banner_component)->toBe('mailcoach')
        ->and($blackFriday->fresh()->banner_component)->toBeNull();
});

it('points the repositories that had a hardcoded banner at their own ad', function () {
    $flare = Ad::factory()->active()->create(['name' => 'Flare']);
    $mediaLibrary = Ad::factory()->inactive()->create(['name' => 'Media Library Pro']);
    $eventSourcing = Ad::factory()->inactive()->create(['name' => 'Event Sourcing in Laravel']);

    $mediaLibraryRepository = Repository::factory()->create([
        'name' => 'laravel-medialibrary',
        'ad_id' => $flare->id,
        'ad_should_be_randomized' => true,
    ]);
    $eventSourcingRepository = Repository::factory()->create([
        'name' => 'laravel-event-sourcing',
        'ad_id' => $flare->id,
        'ad_should_be_randomized' => true,
    ]);

    $this->migration->up();

    expect($mediaLibraryRepository->fresh()->ad_id)->toBe($mediaLibrary->id)
        ->and($mediaLibraryRepository->fresh()->ad_should_be_randomized)->toBeFalse()
        ->and($mediaLibrary->fresh()->active)->toBeTrue()
        ->and($mediaLibrary->fresh()->banner_component)->toBe('medialibrary');

    expect($eventSourcingRepository->fresh()->ad_id)->toBe($eventSourcing->id)
        ->and($eventSourcingRepository->fresh()->ad_should_be_randomized)->toBeFalse()
        ->and($eventSourcing->fresh()->active)->toBeTrue()
        ->and($eventSourcing->fresh()->banner_component)->toBe('event-sourcing');
});

it('renders the medialibrary banner on the medialibrary docs after migrating', function () {
    Ad::factory()->inactive()->create(['name' => 'Media Library Pro']);
    $repository = Repository::factory()->create(['name' => 'laravel-medialibrary', 'ad_id' => null]);

    $this->migration->up();

    $rendered = renderRandomBanner(['repositoryModel' => $repository->fresh()]);

    expect($rendered)->toContain('medialibrary.pro');
});

it('leaves repositories without a matching ad alone', function () {
    $repository = Repository::factory()->create(['name' => 'laravel-medialibrary', 'ad_id' => null]);

    $this->migration->up();

    expect($repository->fresh()->ad_id)->toBeNull();
});
