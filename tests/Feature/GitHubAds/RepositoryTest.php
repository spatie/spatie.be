<?php

namespace Tests\Feature\GitHubAds;

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    private Filesystem $adImagesDisk;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('github_ads');

        $this->adImagesDisk = Storage::disk('github_ads');
    }

    /** @test */
    public function it_will_update_the_ad_image_on_disk_when_a_new_ad_is_associated_with_a_repository()
    {
        /** @var Ad $ad */
        $ad = Ad::factory()->create();

        /** @var Repository $repository */
        $repository = Repository::factory()->create();
        $this->adImagesDisk->assertMissing($repository->gitHubAdImagePath());

        $repository->update(['ad_id' => $ad->id]);
        $this->adImagesDisk->assertExists($repository->gitHubAdImagePath());
    }
}
