<?php

use App\Domain\Experience\Models\Achievement;
use App\Models\Series;
use Tests\TestCase;



test('a series also creates a achievement', function () {
    $series = Series::factory()->create();

    expect(Achievement::query()->forSeries($series)->exists())->toBeTrue();
});
