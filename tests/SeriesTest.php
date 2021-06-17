<?php

namespace Tests\Models;

use App\Domain\Achievements\Models\Achievement;
use App\Models\Series;
use Tests\TestCase;

class SeriesTest extends TestCase
{
    /** @test */
    public function a_series_also_creates_a_achievement()
    {
        $series = Series::factory()->create();

        $this->assertTrue(Achievement::query()->forSeries($series)->exists());
    }
}
