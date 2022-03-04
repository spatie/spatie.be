<?php

use App\Domain\Shop\Commands\RevokeRepositoryAccessForExpiredLicensesCommand;
use App\Domain\Shop\Models\License;
use App\Services\GitHub\GitHubApi;
use Spatie\TestTime\TestTime;

beforeEach(function () {
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

    expect($this->license->assignment->has_repository_access)->toBeFalse();
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

    expect($this->license->assignment->has_repository_access)->toBeFalse();
});

it('will not revoke access for active licenses', function () {
    $this->license->update([
        'expires_at' => now()->addSecond(),
    ]);

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo');

    expect($this->license->assignment->has_repository_access)->toBeTrue();
});

it('will reset the username and revoke access if the user was not found on github', function () {
    expect($this->license->assignment->user->github_username)->not()->toBeNull();

    $this->apiSpy
        ->shouldReceive('revokeAccessToRepo')
        ->andThrow(new RuntimeException('Not Found'));

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    expect($this->license->assignment->user->github_username)->toBeNull();
    expect($this->license->assignment->has_repository_access)->toBeFalse();
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

    expect($this->license->assignment->has_repository_access)->toBeTrue();

    $otherLicense->update([
        'expires_at' => now()->subSecond(),
    ]);

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->apiSpy->shouldHaveReceived('revokeAccessToRepo');
});

it('will change the access rights on the assignment if no repo is linked', function () {
    $this->license->assignment->purchasable->update([
        'repository_access' => '',
    ]);

    expect($this->license->assignment->has_repository_access)->toBeTrue();

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo');

    expect($this->license->assignment->has_repository_access)->toBeFalse();
});
