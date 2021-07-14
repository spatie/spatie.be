<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Events\SeriesCompleted;
use App\Models\Series;
use App\Models\User;
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

        $achievement = $this->resolveAchievement(
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

    protected function resolveAchievement(
        Series $series,
        int $userId,
    ): ?Achievement {
        $achievement = Achievement::forSeries($series)->first();

        if (! $achievement) {
            return null;
        }

        if ($achievement->receivedBy($userId)) {
            return null;
        }

        $user = User::find($userId);

        if (! $user->hasCompleted($series)) {
            return null;
        }

        return $achievement;
    }
}
