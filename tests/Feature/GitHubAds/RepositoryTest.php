<?php

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('github_ads');

    $this->adImagesDisk = Storage::disk('github_ads');
});

it('will update the ad image on disk when a new ad is associated with a repository', function () {
    /** @var Ad $ad */
    $ad = Ad::factory()->create();

    /** @var Repository $repository */
    $repository = Repository::factory()->create();
    $this->adImagesDisk->assertMissing($repository->gitHubAdImagePath());

    $repository->update(['ad_id' => $ad->id]);
    $this->adImagesDisk->assertExists($repository->gitHubAdImagePath());
});

it('will delete the ad image on disk when an ad is detached from a repository', function () {
    $repository = Repository::factory()->withAd()->create();
    $this->adImagesDisk->assertExists($repository->gitHubAdImagePath());

    $repository->update(['ad_id' => null]);
    $this->adImagesDisk->assertMissing($repository->gitHubAdImagePath());
});
