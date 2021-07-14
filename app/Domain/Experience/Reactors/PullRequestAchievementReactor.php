<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\EventQueries\PullRequestCountQuery;
use App\Domain\Experience\Events\PullRequestMerged;
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

        $achievement = $this->resolveAchievement(
            pullRequestCount: $query->count(),
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
        int $pullRequestCount,
        int $userId
    ): ?Achievement {
        return Achievement::forPullRequest()
            ->get()
            ->filter(fn (Achievement $achievement) => $achievement->data['count_requirement'] <= $pullRequestCount)
            ->reject(fn(Achievement $achievement) => $achievement->receivedBy($userId))
            ->first();
    }
}
