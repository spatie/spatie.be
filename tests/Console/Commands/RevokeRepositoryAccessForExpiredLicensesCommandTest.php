<?php

use App\Domain\Shop\Commands\RevokeRepositoryAccessForExpiredLicensesCommand;
use App\Domain\Shop\Models\License;
use App\Services\GitHub\GitHubApi;
use Mockery\MockInterface;
use RuntimeException;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
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
});

it('will revoke repository access for an expired license', function () {
    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->apiSpy->shouldHaveReceived('revokeAccessToRepo', [
        'dummy_username',
        'spatie/repo',
    ])->once();

    $this->assertFalse($this->license->assignment->has_repository_access);
});

it('will revoke repository access for multiple repositories', function () {
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
});

it('will not revoke access for active licenses', function () {
    $this->license->update([
        'expires_at' => now()->addSecond(),
    ]);

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo');

    $this->assertTrue($this->license->assignment->has_repository_access);
});

it('will reset the username and revoke access if the user was not found on github', function () {
    $this->assertNotNull($this->license->assignment->user->github_username);

    $this->apiSpy
        ->shouldReceive('revokeAccessToRepo')
        ->andThrow(new RuntimeException('Not Found'));

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->assertNull($this->license->assignment->user->github_username);
    $this->assertFalse($this->license->assignment->has_repository_access);
});

it('will not revoke access if the user has a different active license', function () {
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
});
