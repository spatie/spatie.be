<?php

namespace App\Domain\Experience\Achievements;

class ExperienceAchievement
{
    public function __construct(
        public int $previousCount,
        public int $currentCount,
        public int $userId,
    ) {
    }
}
