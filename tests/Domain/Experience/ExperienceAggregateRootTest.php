<?php

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Commands\RegisterSeriesCompletion;
use App\Domain\Experience\Commands\RegisterVideoCompletion;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Events\PullRequestMerged;
use App\Domain\Experience\Events\SeriesCompleted;
use App\Domain\Experience\Events\VideoCompleted;
use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Models\Series;
use App\Models\Video;
use App\Support\Uuid\Uuid;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\TestCase;

uses(TestCase::class);

test('add', function () {
    $uuid = Uuid::new();

    $bus = app(CommandBus::class);

    $bus->dispatch(new AddExperience(
        $uuid,
        1,
        50
    ));

    $this->assertDatabaseHas((new UserExperienceProjection())->getTable(), [
        'user_id' => 1,
        'amount' => 50,
    ]);
});

test('unlock achievement', function () {
    $uuid = Uuid::new();

    $bus = app(CommandBus::class);

    $bus->dispatch(new UnlockAchievement(
        $uuid,
        1,
        Achievement::factory()->create()
    ));

    $this->assertDatabaseHas((new UserAchievementProjection())->getTable(), [
        'user_id' => 1,
        'title' => 'test',
    ]);
});

test('pull request can only be registered once', function () {
    $uuid = Uuid::new();

    ExperienceAggregateRoot::fake($uuid)
        ->when(function (ExperienceAggregateRoot $aggregateRoot) use ($uuid) {
            $command = new RegisterPullRequest($uuid, 1, 'test');

            $aggregateRoot->registerPullRequest($command);
            $aggregateRoot->registerPullRequest($command);
        })
        ->assertRecorded([
            new PullRequestMerged(
                1,
                'test'
            )
        ]);
});

test('achievement can only be unlocked once', function () {
    $uuid = Uuid::new();

    /** @var \App\Domain\Experience\Models\Achievement $achievement */
    $achievement = Achievement::factory()->create();

    ExperienceAggregateRoot::fake($uuid)
        ->when(function (ExperienceAggregateRoot $aggregateRoot) use ($achievement, $uuid) {
            $command = new UnlockAchievement($uuid, 1, $achievement);

            $aggregateRoot->unlockAchievement($command);
            $aggregateRoot->unlockAchievement($command);
        })
        ->assertRecorded([
            new AchievementUnlocked(
                1,
                $achievement->id,
                $achievement->slug,
                $achievement->title,
                $achievement->description
            )
        ]);
});

test('series completion can only be registered once', function () {
    $uuid = Uuid::new();

    /** @var \App\Models\Series $series */
    $series = Series::factory()->create();

    ExperienceAggregateRoot::fake($uuid)
        ->when(function (ExperienceAggregateRoot $aggregateRoot) use ($series, $uuid) {
            $command = new RegisterSeriesCompletion($uuid, 1, $series->id);

            $aggregateRoot->registerSeriesCompletion($command);
            $aggregateRoot->registerSeriesCompletion($command);
        })
        ->assertRecorded([
            new SeriesCompleted(
                1,
                $series->id,
            )
        ]);
});

test('video completion can only be registered once', function () {
    $uuid = Uuid::new();

    /** @var \App\Models\Series $series */
    $series = Series::factory()->create();

    /** @var \App\Models\Video $video */
    $video = Video::factory()->make([
        'series_id' => $series->id,
    ]);

    $video->saveQuietly();

    ExperienceAggregateRoot::fake($uuid)
        ->when(function (ExperienceAggregateRoot $aggregateRoot) use ($video, $uuid) {
            $command = new RegisterVideoCompletion($uuid, 1, $video->id);

            $aggregateRoot->registerVideoCompletion($command);
            $aggregateRoot->registerVideoCompletion($command);
        })
        ->assertRecorded([
            new VideoCompleted(
                1,
                $video->id,
                $video->series_id,
            )
        ]);
});
