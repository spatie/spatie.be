<?php

use App\Checks\GitHubTokenCheck;
use App\Providers\HealthServiceProvider;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

function registeredHealthChecks(): array
{
    Health::clearChecks();

    (new HealthServiceProvider(app()))->register();

    return Health::registeredChecks()->map(fn ($check) => $check::class)->all();
}

afterEach(function () {
    unset($_ENV['LARAVEL_CLOUD'], $_SERVER['LARAVEL_CLOUD']);
});

it('checks the disk when not running on laravel cloud', function () {
    expect(registeredHealthChecks())->toContain(UsedDiskSpaceCheck::class);
});

it('does not check the disk on laravel cloud', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';

    expect(registeredHealthChecks())->not->toContain(UsedDiskSpaceCheck::class);
});

it('checks the main GitHub token once when docs use the same token or fall back to it', function (?string $docsToken) {
    config()->set('services.github.token', 'test-api-token');
    config()->set('services.github.docs_access_token', $docsToken);

    registeredHealthChecks();

    $checks = Health::registeredChecks()->filter(fn ($check) => $check instanceof GitHubTokenCheck);

    expect($checks->map->getName()->values()->all())->toBe(['GitHubApiToken']);
})->with([null, '', 'test-api-token']);

it('checks a separately configured GitHub docs token', function (string $docsToken) {
    config()->set('services.github.token', 'test-api-token');
    config()->set('services.github.docs_access_token', $docsToken);

    registeredHealthChecks();

    $checks = Health::registeredChecks()->filter(fn ($check) => $check instanceof GitHubTokenCheck);

    expect($checks->map->getName()->values()->all())->toBe(['GitHubApiToken', 'GitHubDocsToken']);
})->with(['test-docs-token', '   ']);
