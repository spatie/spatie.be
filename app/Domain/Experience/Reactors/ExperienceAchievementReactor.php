<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Achievements\ExperienceAchievement;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\EventQueries\ExperienceAmountQuery;
use App\Domain\Experience\Events\ExperienceEarned;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class ExperienceAchievementReactor extends Reactor
{
    public function __construct(protected CommandBus $bus)
    {
    }

    public function __invoke(ExperienceEarned $event): void
    {
        $query = new ExperienceAmountQuery($event->aggregateRootUuid());

        $achievement = Achievement::resolve(new ExperienceAchievement(
            previousCount: $query->previousCount(),
            currentCount: $query->currentCount(),
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
