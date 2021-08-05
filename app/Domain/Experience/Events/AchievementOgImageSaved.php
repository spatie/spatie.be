<?php

namespace App\Domain\Experience\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AchievementOgImageSaved extends ShouldBeStored
{
    public function __construct(
        public string $userUuid,
        public string $userAchievementUuid,
        public string $imagePath,
    ) {
    }
}
