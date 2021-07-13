<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class VideoCompleted extends ShouldBeStored
{
    public function __construct(
        public int $userId,
        public int $videoId,
        public int $seriesId,
    ) {
    }
}
