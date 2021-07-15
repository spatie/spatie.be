<?php

namespace App\Domain\Experience\Achievements;

class PullRequestAchievement
{
    public function __construct(
        public int $pullRequestCount,
        public int $userId,
    ) {
    }
}
