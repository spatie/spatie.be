<?php

namespace App\Domain\Achievements;

class ExperienceAchievement
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $description,
        public int $countRequirement,
    ) {
    }

    public function matches(int $previousCount, int $currentCount): bool
    {
        return $previousCount < $this->countRequirement && $currentCount >= $this->countRequirement;
    }
}
