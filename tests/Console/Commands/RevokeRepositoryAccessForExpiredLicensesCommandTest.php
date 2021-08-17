<?php

namespace Tests\Console\Commands;

use App\Console\Commands\RevokeRepositoryAccessForExpiredLicensesCommand;
use App\Models\License;
use App\Services\GitHub\GitHubApi;
use Mockery\MockInterface;
use RuntimeException;
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

        $this->license->assignment->user->update([
             'github_username' => 'dummy_username',
        ]);

        $this->license->assignment->update([
            'has_repository_access' => true,
        ]);

        $this->license->assignment->purchasable->update([
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

        $this->assertFalse($this->license->assignment->has_repository_access);
    }

    /** @test */
    public function it_will_revoke_repository_access_for_multiple_repositories()
    {
        $this->license->assignment->purchasable->update([
            'repository_access' => 'spatie/repo, spatie/other-repo',
        ]);

        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->apiSpy->shouldHaveReceived('revokeAccessToRepo', [
            'dummy_username',
            'spatie/repo',
        ])->once();

        $this->apiSpy->shouldHaveReceived('revokeAccessToRepo', [
            'dummy_username',
            'spatie/other-repo',
        ])->once();

        $this->assertFalse($this->license->assignment->has_repository_access);
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

        $this->assertTrue($this->license->assignment->has_repository_access);
    }

    /** @test */
    public function it_will_reset_the_username_and_revoke_access_if_the_user_was_not_found_on_github()
    {
        $this->assertNotNull($this->license->assignment->user->github_username);

        $this->apiSpy
            ->shouldReceive('revokeAccessToRepo')
            ->andThrow(new RuntimeException('Not Found'));

        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->assertNull($this->license->assignment->user->github_username);
        $this->assertFalse($this->license->assignment->has_repository_access);
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

        $otherLicense->assignment->user->update([
            'github_username' => 'dummy_username',
        ]);

        $otherLicense->assignment->update([
            'has_repository_access' => true,
        ]);

        $otherLicense->assignment->purchasable->update([
            'repository_access' => 'spatie/repo',
        ]);

        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo');

        $this->assertTrue($this->license->assignment->has_repository_access);

        $otherLicense->update([
            'expires_at' => now()->subSecond(),
        ]);

        $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

        $this->license->refresh();

        $this->apiSpy->shouldHaveReceived('revokeAccessToRepo');
    }
}
