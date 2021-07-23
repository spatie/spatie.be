<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Achievements\SeriesAchievement;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Events\SeriesCompleted;
use App\Domain\Experience\Models\Achievement;
use App\Models\Series;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class SeriesAchievementReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus,
    ) {
    }

    public function __invoke(SeriesCompleted $event): void
    {
        $series = Series::find($event->seriesId);

        $achievement = Achievement::resolve(new SeriesAchievement(
            series: $series,
            userId: $event->userId,
        ));

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
