<?php

namespace Tests\Models;

use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function test_has_completed()
    {
        /** @var \App\Models\Series $series */
        $series = Series::factory()->create();

        $videoA = Video::factory()->make([
            'series_id' => $series->id,
        ]);

        $videoA->saveQuietly();

        $videoB = Video::factory()->make([
            'series_id' => $series->id,
        ]);

        $videoB->saveQuietly();

        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $this->assertFalse($user->hasCompleted($series));

        $user->completeVideo($videoA);

        $this->assertFalse($user->hasCompleted($series));

        $user->completeVideo($videoB);

        $this->assertTrue($user->hasCompleted($series));
    }
}
