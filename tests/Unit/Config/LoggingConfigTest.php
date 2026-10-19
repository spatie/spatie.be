<?php

it('logs to daily files and flare by default', function () {
    expect(config('logging.default'))->toBe('stack')
        ->and(config('logging.channels.stack.channels'))->toBe(['daily', 'flare'])
        ->and(config('logging.channels.daily.driver'))->toBe('daily')
        ->and(config('logging.channels.daily.days'))->toBe(14);
});

it('can change the stacked channels and retention using env variables', function () {
    $config = configWithEnvironment('logging.php', [
        'LOG_STACK' => 'stderr,flare',
        'LOG_DAILY_DAYS' => '7',
    ]);

    expect($config['channels']['stack']['channels'])->toBe(['stderr', 'flare'])
        ->and($config['channels']['daily']['days'])->toBe(7);
});

it('does not write unrotated geoip failure logs by default', function () {
    expect(config('geoip.log_failures'))->toBeFalse();

    $config = configWithEnvironment('geoip.php', ['GEOIP_LOG_FAILURES' => 'true']);

    expect($config['log_failures'])->toBeTrue();
});
