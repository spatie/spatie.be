<?php

use App\Jobs\PurgeGitHubAdImageCacheJob;
use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
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

it('updates the legacy bucket and queues a purge after an ad changes', function () {
    Storage::fake('github_ads_legacy');
    Queue::fake();
    config()->set('services.github_ads.legacy_disk', 'github_ads_legacy');
    config()->set('services.laravel_cloud.cache_purge_token', 'token');

    $ad = Ad::factory()->active()->create();
    $repository = Repository::factory()->create(['name' => 'laravel-permission', 'ad_id' => $ad->id]);
    $newImage = UploadedFile::fake()->image('new-ad.png');
    Storage::disk('github_ads')->put('new-ad.png', $newImage->get());
    Queue::fake();

    $ad->update(['image' => 'new-ad.png']);

    expect(Storage::disk('github_ads')->get($repository->gitHubAdImagePath()))->toBe($newImage->get())
        ->and(Storage::disk('github_ads_legacy')->get($repository->gitHubAdImagePath()))->toBe($newImage->get());

    Queue::assertPushed(PurgeGitHubAdImageCacheJob::class, fn ($job) => $job->repositoryName === 'laravel-permission' && $job->afterCommit);
});

it('removes both images and queues a purge when the ad is deleted', function () {
    Storage::fake('github_ads_legacy');
    Queue::fake();
    config()->set('services.github_ads.legacy_disk', 'github_ads_legacy');
    config()->set('services.laravel_cloud.cache_purge_token', 'token');
    $repository = Repository::factory()->withAd()->create();
    Queue::fake();

    $repository->ad->delete();

    expect($repository->fresh()->ad_id)->toBeNull();
    Storage::disk('github_ads')->assertMissing($repository->gitHubAdImagePath());
    Storage::disk('github_ads_legacy')->assertMissing($repository->gitHubAdImagePath());
    Queue::assertPushed(PurgeGitHubAdImageCacheJob::class);
});

it('does not rewrite or purge the ad when unrelated repository attributes change', function () {
    Queue::fake();
    config()->set('services.laravel_cloud.cache_purge_token', 'token');
    $repository = Repository::factory()->withAd()->create();
    Queue::fake();

    $repository->update(['stars' => 123]);

    Queue::assertNotPushed(PurgeGitHubAdImageCacheJob::class);
});
