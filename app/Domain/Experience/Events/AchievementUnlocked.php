<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AchievementUnlocked extends ShouldBeStored
{
    public function __construct(
        public string $email,
        public ?int $userId,
        public string $title,
    ) {
    }
}
