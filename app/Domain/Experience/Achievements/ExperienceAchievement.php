<?php

namespace App\Domain\Experience\Achievements;

class ExperienceAchievement implements Achievement
{
    public function __construct(
        private string $slug,
        private string $title,
        private string $description,
        private int $countRequirement,
    ) {
    }

    public function matches(int $previousCount, int $currentCount): bool
    {
        return $previousCount < $this->countRequirement && $currentCount >= $this->countRequirement;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
