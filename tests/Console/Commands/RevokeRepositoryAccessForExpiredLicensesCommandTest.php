<?php

namespace Tests\Console\Commands;

use App\Console\Commands\RevokeRepositoryAccessForExpiredLicensesCommand;
use App\Models\License;
use App\Services\GitHub\GitHubApi;
use Mockery\MockInterface;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class RevokeRepositoryAccessForExpiredLicensesCommandTest extends TestCase
{
    protected License $license;

    protected MockInterface $apiSpy;

    public function setUp(): void
    {
        parent::setUp();

        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $this->license = License::factory()->create([
            'expires_at' => now()->subSecond(),
        ]);

        $this->license->purchase->user->update([
             'github_username' => 'dummy_username',
        ]);

        $this->license->purchase->update([
            'has_repository_access' => true,
        ]);

        $this->license->purchase->purchasable->update([
            'repository_access' => 'spatie/repo',
        ]);

        $this->apiSpy = $this->spy(GitHubApi::class);
    }

    /** @test */
    public function it_will_revoke_repository_access_for_an_expired_license()
    {
        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->apiSpy->shouldHaveReceived('revokeAccessToRepo', [
            'dummy_username',
            'spatie/repo',
        ])->once();

        $this->assertFalse($this->license->purchase->has_repository_access);
    }

    /** @test */
    public function it_will_not_revoke_access_for_active_licenses()
    {
        $this->license->update([
            'expires_at' => now()->addSecond(),
        ]);

        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo');

        $this->assertTrue($this->license->purchase->has_repository_access);
    }

    /** @test */
    public function it_will_not_revoke_access_if_the_user_has_a_different_active_license()
    {
        $this->license->update([
            'expires_at' => now()->addSecond(),
        ]);

        $otherLicense = License::factory()->create([
            'expires_at' => now()->addSecond(),
        ]);

        $otherLicense->purchase->user->update([
            'github_username' => 'dummy_username',
        ]);

        $otherLicense->purchase->update([
            'has_repository_access' => true,
        ]);

        $otherLicense->purchase->purchasable->update([
            'repository_access' => 'spatie/repo',
        ]);

        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo');

        $this->assertTrue($this->license->purchase->has_repository_access);

        $otherLicense->update([
            'expires_at' => now()->subSecond(),
        ]);

        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->apiSpy->shouldHaveReceived('revokeAccessToRepo');
    }
}
