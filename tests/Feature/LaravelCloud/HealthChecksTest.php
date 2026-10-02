<?php

use App\Providers\HealthServiceProvider;
use Spatie\Health\Checks\Checks\HorizonCheck;
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

it('checks horizon and the disk when not running on laravel cloud', function () {
    expect(registeredHealthChecks())
        ->toContain(HorizonCheck::class)
        ->toContain(UsedDiskSpaceCheck::class);
});

it('does not check horizon and the disk on laravel cloud', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';

    expect(registeredHealthChecks())
        ->not->toContain(HorizonCheck::class)
        ->not->toContain(UsedDiskSpaceCheck::class);
});
