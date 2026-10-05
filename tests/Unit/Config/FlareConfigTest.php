<?php

use Monolog\Level;
use Spatie\FlareClient\Flare;
use Spatie\LaravelFlare\FlareConfig;
use Spatie\LaravelRay\Watchers\ExceptionWatcher;

it('traces a small sample of requests by default', function () {
    expect(config('flare.trace'))->toBeTrue()
        ->and(config('flare.sampler.config.rate'))->toBe(0.02);
});

it('can change tracing using env variables', function () {
    $config = configWithEnvironment('flare.php', [
        'FLARE_TRACE' => 'false',
        'FLARE_SAMPLER_RATE' => '0.5',
    ]);

    expect($config['trace'])->toBeFalse()
        ->and($config['sampler']['config']['rate'])->toBe('0.5');
});

it('only sends error logs to flare', function () {
    expect(config('flare.minimal_log_level'))->toBe(Level::Error);
});

it('reports exceptions to flare', function () {
    app(ExceptionWatcher::class)->disable();

    app(FlareConfig::class)->apiToken = 'fake-flare-key';

    $flare = Mockery::spy(Flare::class);
    app()->instance(Flare::class, $flare);

    report(new RuntimeException('Something went wrong'));

    $flare->shouldHaveReceived('report')
        ->withArgs(fn (Throwable $exception) => $exception->getMessage() === 'Something went wrong')
        ->once();
});
