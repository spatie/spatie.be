<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Events\VideoCompleted;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Enums\ExperienceType;
use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use Tests\TestCase;

class VideoCompletionTest extends TestCase
{
    private Series $series;

    private Video $videoA;

    private Video $videoB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->series = Series::factory()->create();

        $this->videoA = Video::factory()->make([
            'series_id' => $this->series->id,
        ]);

        $this->videoA->saveQuietly();

        $this->videoB = Video::factory()->make([
            'series_id' => $this->series->id,
        ]);

        $this->videoB->saveQuietly();
    }

    /** @test */
    public function a_series_is_completed_when_all_videos_are_completed_()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $achievement = Achievement::forSeries($this->series)->first();

        $user->completeVideo($this->videoA);

        $this->assertFalse($user->hasAchievement($achievement));

        $user->completeVideo($this->videoB);

        $this->assertTrue($user->hasAchievement($achievement));
    }

    /** @test */
    public function experience_is_gained_per_completion()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->completeVideo($this->videoA);

        $this->assertEquals(ExperienceType::VideoCompletion()->getAmount(), $user->experience->amount);
    }

    /** @test */
    public function experience_is_gained_per_series()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->completeVideo($this->videoA);
        $user->completeVideo($this->videoB);

        $expectedAmount =
            2 * ExperienceType::VideoCompletion()->getAmount()
            + ExperienceType::SeriesCompletion()->getAmount();

        $this->assertEquals(
            $expectedAmount,
            $user->experience->amount
        );
    }

    /** @test */
    public function same_video_cant_be_registered_twice()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->completeVideo($this->videoA);
        $user->completeVideo($this->videoA);

        $this->assertEquals(1, EloquentStoredEvent::query()->whereEvent(VideoCompleted::class)->count());
    }

    // TODO: what if a user uncompletes a video?
}
