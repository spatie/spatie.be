<?php

use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Events\VideoCompleted;
use App\Domain\Experience\Models\Achievement;
use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

beforeEach(function () {
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

    expect($user->hasAchievement($achievement))->toBeFalse();

    $user->completeVideo($this->videoB);

    expect($user->hasAchievement($achievement))->toBeTrue();
});

test('experience is gained per completion', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $user->completeVideo($this->videoA);

    expect($user->experience->amount)->toEqual(ExperienceType::VideoCompletion()->getAmount());
});

test('experience is gained per series', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $user->completeVideo($this->videoA);
    $user->completeVideo($this->videoB);

    $expectedAmount =
        2 * ExperienceType::VideoCompletion()->getAmount()
        + ExperienceType::SeriesCompletion()->getAmount();

    expect($user->experience->amount)->toEqual($expectedAmount);
});

test('same video cant be registered twice', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $user->completeVideo($this->videoA);
    $user->completeVideo($this->videoA);

    expect(EloquentStoredEvent::query()->whereEvent(VideoCompleted::class)->count())->toEqual(1);
});
