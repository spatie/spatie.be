<?php

use App\Services\GitHub\GitHubApi;
use App\Services\GitHub\RepositoryAccessStatus;
use Github\Api\Repo;
use Github\Api\Repository\Collaborators;
use Github\Client;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config()->set('services.github.token', 'test-api-token');
    config()->set('cache.default', 'array');
    Http::preventStrayRequests();
    $this->api = new GitHubApi(Mockery::mock(Client::class));
});

it('confirms access only from GitHub and caches it briefly', function () {
    $this->freezeTime();
    Http::fake(['api.github.com/repos/*/collaborators/*' => Http::response('', 204)]);

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => RepositoryAccessStatus::Granted]);
    $this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']);
    Http::assertSentCount(1);
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.github.com/repos/spatie/mailcoach/collaborators/customer'
        && $request->hasHeader('Authorization', 'Bearer test-api-token'));

    $this->travel(61)->seconds();
    $this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']);
    Http::assertSentCount(2);
});

it('does not share cached results between GitHub accounts or credentials', function () {
    Http::fake(['api.github.com/repos/*/collaborators/*' => Http::response('', 204)]);

    $this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']);
    $this->api->repositoryAccessStatuses('another-customer', ['spatie/mailcoach']);
    config()->set('services.github.token', 'replacement-token');
    $this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']);

    Http::assertSentCount(3);
});

it('distinguishes missing access and pending invitations', function (array $invitations, RepositoryAccessStatus $expectedStatus) {
    Http::fake([
        'api.github.com/repos/*/collaborators/*' => Http::response([], 404),
        'api.github.com/repos/*/invitations*' => Http::response($invitations),
    ]);

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => $expectedStatus]);
    Http::assertSentCount(2);
})->with([
    'no invitations' => [[], RepositoryAccessStatus::Missing],
    'another user invited' => [[['invitee' => ['login' => 'someone-else']]], RepositoryAccessStatus::Missing],
    'this user invited with different capitalization' => [[['invitee' => ['login' => 'CUSTOMER']]], RepositoryAccessStatus::Pending],
]);

it('checks subsequent invitation pages before deciding access is missing', function () {
    Http::fake([
        'api.github.com/repos/*/collaborators/*' => Http::response([], 404),
        'api.github.com/repos/*/invitations?per_page=100&page=1' => Http::response([['invitee' => ['login' => 'someone-else']]], 200, [
            'Link' => '<https://api.github.com/repos/spatie/mailcoach/invitations?per_page=100&page=2>; rel="next"',
        ]),
        'api.github.com/repos/*/invitations?per_page=100&page=2' => Http::response([['invitee' => ['login' => 'customer']]]),
    ]);

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => RepositoryAccessStatus::Pending]);
    Http::assertSentCount(3);
});

it('leaves incomplete invitation pagination unknown', function () {
    Http::fake([
        'api.github.com/repos/*/collaborators/*' => Http::response([], 404),
        'api.github.com/repos/*/invitations*' => Http::response([], 200, ['Link' => '<https://api.github.com/next>; rel="next"']),
    ]);

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => RepositoryAccessStatus::Unknown]);
    Http::assertSentCount(4);
});

it('treats failed collaborator checks as unknown', function (int $status) {
    Http::fake(['api.github.com/repos/*/collaborators/*' => Http::response([], $status)]);

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => RepositoryAccessStatus::Unknown]);
    Http::assertSentCount(1);
})->with([200, 302, 401, 403, 429, 503]);

it('does not interpret an ambiguous collaborator 404 as missing access', function (int $status, array $body) {
    Http::fake([
        'api.github.com/repos/*/collaborators/*' => Http::response([], 404),
        'api.github.com/repos/*/invitations*' => Http::response($body, $status),
    ]);

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => RepositoryAccessStatus::Unknown]);
})->with([
    'invalid credentials' => [401, []],
    'missing permissions' => [403, []],
    'hidden repository' => [404, []],
    'rate limit' => [429, []],
    'unavailable' => [503, []],
    'unexpected response' => [200, ['message' => 'Unexpected response']],
]);

it('keeps other repository results when one connection fails', function () {
    Http::fake([
        'api.github.com/repos/spatie/mailcoach/collaborators/*' => Http::response('', 204),
        'api.github.com/repos/spatie/medialibrary-pro/collaborators/*' => Http::failedConnection(),
    ]);

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach', 'spatie/medialibrary-pro']))
        ->toBe([
            'spatie/mailcoach' => RepositoryAccessStatus::Granted,
            'spatie/medialibrary-pro' => RepositoryAccessStatus::Unknown,
        ]);
});

it('does not make unauthenticated access checks when the token is missing', function () {
    config()->set('services.github.token', null);
    Http::fake();

    expect($this->api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => RepositoryAccessStatus::Unknown]);
    Http::assertNothingSent();
});

it('invalidates cached access after invitations and revocations', function (string $operation) {
    $collaborators = Mockery::mock(Collaborators::class);
    $collaborators->shouldReceive($operation)->once();
    $repo = Mockery::mock(Repo::class);
    $repo->shouldReceive('collaborators')->andReturn($collaborators);
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('repo')->andReturn($repo);
    $api = new GitHubApi($client);
    Http::fake([
        'api.github.com/repos/*/collaborators/*' => Http::sequence()->push('', 204)->push([], 404),
        'api.github.com/repos/*/invitations*' => Http::response([]),
    ]);
    $api->repositoryAccessStatuses('customer', ['spatie/mailcoach']);

    if ($operation === 'add') {
        $api->inviteToRepo('customer', 'spatie/mailcoach');
    } else {
        $api->revokeAccessToRepo('customer', 'spatie/mailcoach');
    }

    expect($api->repositoryAccessStatuses('customer', ['spatie/mailcoach']))
        ->toBe(['spatie/mailcoach' => RepositoryAccessStatus::Missing]);
    Http::assertSentCount(3);
})->with(['add', 'remove']);
