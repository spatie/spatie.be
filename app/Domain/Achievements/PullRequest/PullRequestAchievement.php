<?php

namespace App\Domain\Achievements\PullRequest;

class PullRequestAchievement
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $description,
        public int $countRequirement,
    ) {
    }

    public function matches(int $count): bool
    {
        return $count >= $this->countRequirement;
    }
}
