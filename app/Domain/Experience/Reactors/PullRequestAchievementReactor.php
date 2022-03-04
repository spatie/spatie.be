<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Achievements\PullRequestAchievement;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\EventQueries\PullRequestCountQuery;
use App\Domain\Experience\Events\PullRequestMerged;
use App\Domain\Experience\Models\Achievement;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class PullRequestAchievementReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus,
    ) {
    }

    public function __invoke(PullRequestMerged $event): void
    {
        $query = new PullRequestCountQuery($event->aggregateRootUuid());

        $achievement = Achievement::resolve(new PullRequestAchievement(
            pullRequestCount: $query->count(),
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
