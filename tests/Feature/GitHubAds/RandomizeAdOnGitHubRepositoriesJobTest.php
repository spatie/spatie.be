<?php

use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use App\Models\Ad;
use App\Models\Repository;

it('can randomize ads on git hub repositories', function () {
    $ads = collect([14, 16, 17])->map(fn ($id) => Ad::factory()->active()->create(['id' => $id]));

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) use ($ads) {
        expect($repository->refresh()->ad_id)->toBeIn($ads->pluck('id')->toArray());
    });
});

it('will only use active ads', function () {
    Ad::factory()->count(10)->inactive()->create();

    $targetAd = Ad::factory()->active()->create();

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) use ($targetAd) {
        expect($repository->refresh()->ad_id)->toEqual($targetAd->id);
    });
});

it('will not update a repository whose ad should not be randomized', function () {
    collect([14, 16, 17])->each(fn ($id) => Ad::factory()->active()->create(['id' => $id]));

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => false,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) {
        expect($repository->refresh()->ad_id)->toBeNull();
    });
});

it('does nothing when no ads are active', function () {
    Ad::factory()->count(10)->inactive()->create();

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) {
        expect($repository->refresh()->ad_id)->toBeNull();
    });
});
