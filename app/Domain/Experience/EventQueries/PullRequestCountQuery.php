<?php

namespace App\Domain\Experience\EventQueries;

use App\Domain\Experience\Events\PullRequestMerged;
use Spatie\EventSourcing\EventHandlers\Projectors\EventQuery;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class PullRequestCountQuery extends EventQuery
{
    private int $count = 0;

    public function __construct(
        string $aggregateUuid
    ) {
        EloquentStoredEvent::query()
            ->whereAggregateRoot($aggregateUuid)
            ->whereEvent(PullRequestMerged::class)
            ->each(fn (EloquentStoredEvent $event) => $this->apply($event->toStoredEvent()));
    }

    public function onPullRequestMerged(PullRequestMerged $event): void
    {
        $this->count += 1;
    }

    public function count(): int
    {
        return $this->count;
    }
}
