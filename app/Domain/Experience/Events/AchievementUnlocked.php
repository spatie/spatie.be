<?php

namespace App\Domain\Experience\Events;

use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AchievementUnlocked extends ShouldBeStored
{
    public function __construct(
        public UserExperienceId $id,
        public string $slug,
        public string $title,
        public string $description,
    ) {
    }
}
