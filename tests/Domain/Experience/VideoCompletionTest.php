<?php

use App\Domain\Experience\Events\VideoCompleted;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Enums\ExperienceType;
use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
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
});

test('a series is completed when all videos are completed', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $achievement = Achievement::forSeries($this->series)->first();

    $user->completeVideo($this->videoA);

    $this->assertFalse($user->hasAchievement($achievement));

    $user->completeVideo($this->videoB);

    $this->assertTrue($user->hasAchievement($achievement));
});

test('experience is gained per completion', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $user->completeVideo($this->videoA);

    $this->assertEquals(ExperienceType::VideoCompletion()->getAmount(), $user->experience->amount);
});

test('experience is gained per series', function () {
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
});

test('same video cant be registered twice', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $user->completeVideo($this->videoA);
    $user->completeVideo($this->videoA);

    $this->assertEquals(1, EloquentStoredEvent::query()->whereEvent(VideoCompleted::class)->count());
});
