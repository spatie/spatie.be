<?php

namespace App\Domain\Achievements\PullRequest;

use App\Domain\Achievements\Models\Achievement;

class PullRequestAchievementUnlocker
{
    public function achievementToBeUnlocked(
        int $pullRequestCount,
        int $userId
    ): ?Achievement {
        return Achievement::forPullRequest()
            ->get()
            ->filter(fn (Achievement $achievement) => $achievement->data['count_requirement'] <= $pullRequestCount)
            ->reject(fn(Achievement $achievement) => $achievement->receivedBy($userId))
            ->first();
    }
}
