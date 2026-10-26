<?php

use App\Services\GitHub\Exceptions\GitHubTwoFactorAuthenticationRequired;
use App\Services\GitHub\GitHubApi;
use Github\Api\Repo;
use Github\Api\Repository\Collaborators;
use Github\Client;
use Github\Exception\RuntimeException;
use Github\Exception\ValidationFailedException;

it('recognizes explicit two-factor rejections when inviting repository collaborators', function (string $message, int $status) {
    $rejection = $status === 422
        ? new ValidationFailedException($message, $status)
        : new RuntimeException($message, $status);
    $collaborators = Mockery::mock(Collaborators::class);
    $collaborators->shouldReceive('add')->once()
        ->with('spatie', 'laravel-mailcoach', 'customer', ['permission' => 'pull'])
        ->andThrow($rejection);
    $repo = Mockery::mock(Repo::class);
    $repo->shouldReceive('collaborators')->andReturn($collaborators);
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('repo')->andReturn($repo);

    try {
        (new GitHubApi($client))->inviteToRepo('customer', 'spatie/laravel-mailcoach');
        $this->fail('Expected a two-factor authentication error.');
    } catch (GitHubTwoFactorAuthenticationRequired $exception) {
        expect($exception->getPrevious())->toBe($rejection);
        expect($exception->getMessage())->toContain('remove SMS authentication');
    }
})->with([
    ['Two-factor authentication is required by this organization.', 403],
    ['Validation Failed: secure two factor authentication is required.', 422],
    ['The user must enable secure 2FA.', 403],
]);

it('keeps unrelated invitation failures as their original errors', function (string $message, int $status) {
    $rejection = $status === 422
        ? new ValidationFailedException($message, $status)
        : new RuntimeException($message, $status);
    $collaborators = Mockery::mock(Collaborators::class);
    $collaborators->shouldReceive('add')->once()->andThrow($rejection);
    $repo = Mockery::mock(Repo::class);
    $repo->shouldReceive('collaborators')->andReturn($collaborators);
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('repo')->andReturn($repo);

    try {
        (new GitHubApi($client))->inviteToRepo('customer', 'spatie/laravel-mailcoach');
        $this->fail('Expected the original GitHub error.');
    } catch (RuntimeException|ValidationFailedException $exception) {
        expect($exception)->toBe($rejection);
    }
})->with([
    ['Resource not accessible by personal access token', 403],
    ['API rate limit exceeded', 403],
    ['Validation Failed: repository not found', 422],
    ['Two-factor service temporarily unavailable', 503],
]);
