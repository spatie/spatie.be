<?php

use App\Domain\Experience\Models\Achievement;
use App\Models\Series;
use Tests\TestCase;

uses(TestCase::class);

test('a series also creates a achievement', function () {
    $series = Series::factory()->create();

    $this->assertTrue(Achievement::query()->forSeries($series)->exists());
});
