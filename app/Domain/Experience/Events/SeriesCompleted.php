<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class SeriesCompleted extends ShouldBeStored
{
    public function __construct(
        public int $userId,
        public int $seriesId
    ) {
    }
}
