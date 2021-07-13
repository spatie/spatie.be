<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Achievements\Series\SeriesCompletionAchievementUnlocker;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\EventQueries\ExperienceAmountQuery;
use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Events\SeriesCompleted;
use App\Models\Series;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class SeriesAchievementReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus,
        protected SeriesCompletionAchievementUnlocker $unlocker
    ) {
    }

    public function __invoke(SeriesCompleted $event): void
    {
        $series = Series::find($event->seriesId);

        $achievement = $this->unlocker->achievementToBeUnlocked(
            series: $series,
            userId: $event->userId,
        );

        if (! $achievement) {
            return;
        }

        $this->bus->dispatch(new UnlockAchievement(
            uuid: $event->aggregateRootUuid(),
            userId: $event->userId,
            achievement: $achievement,
        ));
    }
}
