<?php

use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

beforeEach(function () {
    Storage::fake();
});

it('can randomize ads on git hub repositories', function () {
    Ad::factory()->count(10)->create();

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) {
        expect($repository->refresh()->ad)->not()->toBeNull();
        Storage::disk('github_ads')->assertExists($repository->gitHubAdImagePath());
    });
});

it('will not use ads that are not active', function () {
    Ad::factory()->inactive()->count(10)->create();

    $activeAd = Ad::factory()->active()->create();
    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) use ($activeAd) {
        expect($repository->refresh()->ad_id)->toEqual($activeAd->id);
    });
});

it('will not update a repository whose ad should not be randomized', function () {
    Ad::factory()->count(10)->create();

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => false,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) {
        expect($repository->refresh()->ad_id)->toBeNull();
    });
});
