<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\EventQueries\ExperienceAmountQuery;
use App\Domain\Experience\Events\ExperienceEarned;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class ExperienceAchievementReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus,
    ) {
    }

    public function __invoke(ExperienceEarned $event): void
    {
        $query = new ExperienceAmountQuery($event->aggregateRootUuid());

        $achievement = $this->resolveAchievement(
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

    protected function resolveAchievement(
        int $previousCount,
        int $currentCount,
        int $userId
    ): ?Achievement {
        return Achievement::forExperience()
            ->get()
            ->filter(fn (Achievement $achievement) => $previousCount < $achievement->data['count_requirement'])
            ->filter(fn (Achievement $achievement) => $currentCount >= $achievement->data['count_requirement'])
            ->reject(fn (Achievement $achievement) => $achievement->receivedBy($userId))
            ->first();
    }
}
