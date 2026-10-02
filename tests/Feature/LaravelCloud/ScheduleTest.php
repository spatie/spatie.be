<?php

use App\Console\Kernel;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;

/** @return array<int, Event> */
function scheduledEvents(): array
{
    $schedule = new Schedule();

    Closure::bind(
        fn (Schedule $schedule) => $this->schedule($schedule),
        app(Kernel::class),
        Kernel::class,
    )($schedule);

    return $schedule->events();
}

afterEach(function () {
    unset($_ENV['LARAVEL_CLOUD'], $_SERVER['LARAVEL_CLOUD']);
});

it('runs every scheduled task on one server', function () {
    expect(scheduledEvents())->each(fn ($event) => $event->onOneServer->toBeTrue());
});

it('updates the geoip database when not running on laravel cloud', function () {
    $commands = collect(scheduledEvents())->pluck('command')->implode(' ');

    expect($commands)->toContain('geoip:update');
});

it('does not update the geoip database on laravel cloud', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';

    $commands = collect(scheduledEvents())->pluck('command')->implode(' ');

    expect($commands)->not->toContain('geoip:update');
});
