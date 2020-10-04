<?php

namespace Tests\Feature\GitHubAds;

use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RandomizeAdOnGitHubRepositoriesJobTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    /** @test */
    public function it_can_randomize_ads_on_GitHub_repositories()
    {
        Ad::factory()->count(10)->create();

        $repositories = Repository::factory()->count(10)->create([
            'ad_should_be_randomized' => true,
        ]);

        dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

        $repositories->each(function (Repository $repository) {
            $this->assertNotNull($repository->refresh()->ad);

            Storage::disk('github_ads')->assertExists($repository->gitHubAdImagePath());
        });
    }

    /** @test */
    public function it_will_not_use_ads_that_are_not_active()
    {
        Ad::factory()->inactive()->count(10)->create();

        $activeAd = Ad::factory()->active()->create();
        $repositories = Repository::factory()->count(10)->create([
            'ad_should_be_randomized' => true,
        ]);

        dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

        $repositories->each(function (Repository $repository) use ($activeAd) {
            $this->assertEquals($activeAd->id, $repository->refresh()->ad_id);
        });
    }

    /** @test */
    public function it_will_not_update_a_repository_whose_ad_should_not_be_randomized()
    {
        Ad::factory()->count(10)->create();

        $repositories = Repository::factory()->count(10)->create([
            'ad_should_be_randomized' => false,
        ]);

        dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

        $repositories->each(function (Repository $repository) {
            $this->assertNull($repository->refresh()->ad_id);
        });
    }
}
