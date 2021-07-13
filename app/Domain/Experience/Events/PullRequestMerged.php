<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PullRequestMerged extends ShouldBeStored
{
    public function __construct(
        public int $userId,
    ) {
    }
}
