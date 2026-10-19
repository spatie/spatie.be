<?php

use App\Domain\Shop\Commands\RevokeRepositoryAccessForExpiredLicensesCommand;
use App\Domain\Shop\Exceptions\CouldNotRevokeRepositoryAccess;
use App\Domain\Shop\Models\License;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Facades\Exceptions;
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

    $this->apiSpy->shouldReceive('userExists')->andReturn(true)->byDefault();
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

it('will revoke access for the current username when the user renamed their github account', function () {
    $this->license->assignment->user->update([
        'github_id' => 12345,
    ]);

    $this->apiSpy->shouldReceive('userExists')->with('dummy_username')->andReturn(false);
    $this->apiSpy->shouldReceive('getUsernameForId')->with(12345)->andReturn('renamed_username');

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->apiSpy->shouldHaveReceived('revokeAccessToRepo', [
        'renamed_username',
        'spatie/repo',
    ])->once();

    $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo', [
        'dummy_username',
        'spatie/repo',
    ]);

    expect($this->license->assignment->user->github_username)->toBe('renamed_username');
    expect($this->license->assignment->has_repository_access)->toBeFalse();
});

it('will reset the username and revoke access if the github account no longer exists', function () {
    $this->license->assignment->user->update([
        'github_id' => 12345,
    ]);

    $this->apiSpy->shouldReceive('userExists')->with('dummy_username')->andReturn(false);
    $this->apiSpy->shouldReceive('getUsernameForId')->with(12345)->andReturn(null);

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    $this->apiSpy->shouldNotHaveReceived('revokeAccessToRepo');

    expect($this->license->assignment->user->github_username)->toBeNull();
    expect($this->license->assignment->has_repository_access)->toBeFalse();
});

it('will report an exception and keep access when revoking fails', function () {
    Exceptions::fake();

    $this->apiSpy
        ->shouldReceive('revokeAccessToRepo')
        ->andThrow(new RuntimeException('Resource not accessible by personal access token'));

    $this->artisan(RevokeRepositoryAccessForExpiredLicensesCommand::class);

    $this->license->refresh();

    Exceptions::assertReported(function (CouldNotRevokeRepositoryAccess $exception) {
        return str_contains($exception->getMessage(), 'dummy_username')
            && str_contains($exception->getMessage(), 'Resource not accessible by personal access token');
    });

    expect($this->license->assignment->has_repository_access)->toBeTrue();
});
