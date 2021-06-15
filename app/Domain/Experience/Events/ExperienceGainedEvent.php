<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ExperienceGainedEvent extends ShouldBeStored
{
    public function __construct(
        public string $email,
        public ?int $userId,
        public int $amount,
        public string $type,
    ) {
    }
}
