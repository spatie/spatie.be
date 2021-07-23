<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AchievementUnlocked extends ShouldBeStored
{
    public function __construct(
        public int $userId,
        public int $achievementId,
        public string $slug,
        public string $title,
        public string $description,
    ) {
    }
}
