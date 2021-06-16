<?php

namespace App\Domain\Experience\Events;

use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ExperienceEarned extends ShouldBeStored
{
    public function __construct(
        public UserExperienceId $id,
        public int $amount,
        public string $type,
    ) {
    }
}
