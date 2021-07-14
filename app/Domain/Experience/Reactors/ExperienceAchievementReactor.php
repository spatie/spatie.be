<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Achievements\Experience\ExperienceAchievementUnlocker;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\EventQueries\ExperienceAmountQuery;
use App\Domain\Experience\Events\ExperienceEarned;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class ExperienceAchievementReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus,
        protected ExperienceAchievementUnlocker $unlocker
    ) {
    }

    public function __invoke(ExperienceEarned $event): void
    {
        $query = new ExperienceAmountQuery($event->aggregateRootUuid());

        $achievement = $this->unlocker->achievementToBeUnlocked(
            previousCount: $query->previousCount(),
            currentCount: $query->currentCount(),
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
