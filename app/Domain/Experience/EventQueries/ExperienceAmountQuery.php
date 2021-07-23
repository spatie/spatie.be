<?php

namespace App\Domain\Experience\EventQueries;

use App\Domain\Experience\Events\ExperienceEarned;
use Spatie\EventSourcing\EventHandlers\Projectors\EventQuery;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class ExperienceAmountQuery extends EventQuery
{
    private int $currentCount = 0;

    private int $latestCount = 0;

    public function __construct(
        string $aggregateUuid
    ) {
        EloquentStoredEvent::query()
            ->whereAggregateRoot($aggregateUuid)
            ->whereEvent(ExperienceEarned::class)
            ->each(fn (EloquentStoredEvent $event) => $this->apply($event->toStoredEvent()));
    }

    public function onPullRequestMerged(ExperienceEarned $event): void
    {
        $this->currentCount += $event->amount;
        $this->latestCount = $event->amount;
    }

    public function currentCount(): int
    {
        return $this->currentCount;
    }

    public function previousCount(): int
    {
        return $this->currentCount - $this->latestCount;
    }
}
