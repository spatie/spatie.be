<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Achievements\PullRequest\PullRequestAchievementUnlocker;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\EventQueries\PullRequestCountQuery;
use App\Domain\Experience\Events\PullRequestMerged;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class PullRequestAchievementReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus,
        protected PullRequestAchievementUnlocker $unlocker
    ) {
    }

    public function __invoke(PullRequestMerged $event): void
    {
        $achievement = $this->unlocker->achievementToBeUnlocked(
            pullRequestCount: (new PullRequestCountQuery($event->aggregateRootUuid()))->count(),
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
