<?php

namespace App\Domain\Experience\Events;

use App\Domain\Experience\Enums\ExperienceType;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ExperienceEarned extends ShouldBeStored
{
    public function __construct(
        public string $email,
        public ?int $userId,
        public int $amount,
        public ExperienceType $type,
    ) {
    }
}
