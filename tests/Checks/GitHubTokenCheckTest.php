<?php

use App\Checks\GitHubTokenCheck;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
    config()->set('services.github.token', 'test-api-token');
    config()->set('services.github.docs_access_token', 'test-docs-token');
});

it('authenticates the configured token with a read-only GitHub request', function (string $configKey, string $token) {
    Http::fake(['api.github.com/user' => Http::response(['id' => 12345, 'login' => 'spatie-bot'])]);

    $result = GitHubTokenCheck::new()->tokenConfigKey($configKey)->run();

    expect($result->status->value)->toBe('ok');
    expect($result->shortSummary)->toBe('Authenticated');
    expect($result->meta)->toBe(['config_key' => $configKey]);
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.github.com/user'
        && $request->hasHeader('Authorization', "Bearer {$token}")
        && $request->hasHeader('User-Agent', 'spatie.be health check'));
    Http::assertSentCount(1);
})->with([
    ['services.github.token', 'test-api-token'],
    ['services.github.docs_access_token', 'test-docs-token'],
]);

it('fails without making a request when the token is missing', function (?string $token) {
    Http::fake();
    config()->set('services.github.token', $token);

    $result = GitHubTokenCheck::new()->run();

    expect($result->status->value)->toBe('failed');
    expect($result->shortSummary)->toBe('Missing token');
    Http::assertNothingSent();
})->with([null, '', '   ']);

it('distinguishes invalid credentials from GitHub availability and rate-limit problems', function (int $status, array $headers, string $expectedStatus, string $summary) {
    Http::fake(['api.github.com/user' => Http::response(['message' => 'test-api-token must never appear in health output'], $status, $headers)]);

    $result = GitHubTokenCheck::new()->label('GitHub API token')->run();

    expect($result->status->value)->toBe($expectedStatus);
    expect($result->shortSummary)->toBe($summary);
    expect(json_encode($result))->not->toContain('test-api-token');
})->with([
    'expired or revoked token' => [401, [], 'failed', 'Invalid token'],
    'forbidden' => [403, [], 'failed', 'Token validation failed'],
    'primary rate limit' => [403, ['X-RateLimit-Remaining' => '0'], 'warning', 'GitHub rate limited'],
    'secondary rate limit' => [403, ['Retry-After' => '60'], 'warning', 'GitHub rate limited'],
    'rate limit' => [429, [], 'warning', 'GitHub rate limited'],
    'GitHub unavailable' => [503, [], 'warning', 'GitHub unavailable'],
    'redirect' => [302, ['Location' => 'https://example.com'], 'failed', 'Token validation failed'],
]);

it('does not report successful authentication for an unexpected response', function () {
    Http::fake(['api.github.com/user' => Http::response(['message' => 'Unexpected response'])]);

    $result = GitHubTokenCheck::new()->run();

    expect($result->status->value)->toBe('failed');
    expect($result->shortSummary)->toBe('Unexpected GitHub response');
});

it('reports connectivity problems without exposing exception details', function () {
    Http::fake(fn () => throw new ConnectionException('Could not validate test-api-token'));

    $result = GitHubTokenCheck::new()->run();

    expect($result->status->value)->toBe('warning');
    expect($result->shortSummary)->toBe('GitHub unreachable');
    expect(json_encode($result))->not->toContain('test-api-token');
});
