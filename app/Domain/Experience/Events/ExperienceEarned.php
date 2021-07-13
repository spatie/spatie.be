<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ExperienceEarned extends ShouldBeStored
{
    public function __construct(
        public int $userId,
        public int $amount,
    ) {
    }
}
