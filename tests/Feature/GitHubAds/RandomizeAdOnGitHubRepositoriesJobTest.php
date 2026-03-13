<?php

use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use App\Models\Ad;
use App\Models\Repository;

it('can randomize ads on git hub repositories', function () {
    $ads = collect([4, 5, 7, 9])->map(fn ($id) => Ad::factory()->create(['id' => $id]));

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) use ($ads) {
        expect($repository->refresh()->ad_id)->toBeIn($ads->pluck('id')->toArray());
    });
});

it('will only use ads with the hardcoded ids', function () {
    Ad::factory()->count(10)->create();

    $targetAd = Ad::factory()->create(['id' => 4]);

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) use ($targetAd) {
        expect($repository->refresh()->ad_id)->toEqual($targetAd->id);
    });
});

it('will not update a repository whose ad should not be randomized', function () {
    collect([4, 5, 7, 9])->each(fn ($id) => Ad::factory()->create(['id' => $id]));

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => false,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) {
        expect($repository->refresh()->ad_id)->toBeNull();
    });
});

it('does nothing when none of the hardcoded ad ids exist', function () {
    Ad::factory()->count(10)->create();

    $repositories = Repository::factory()->count(10)->create([
        'ad_should_be_randomized' => true,
    ]);

    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    $repositories->each(function (Repository $repository) {
        expect($repository->refresh()->ad_id)->toBeNull();
    });
});
