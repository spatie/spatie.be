<?php

namespace App\Domain\Achievements\PullRequest;

use App\Domain\Achievements\Models\Achievement;
use App\Domain\Experience\ValueObjects\UserExperienceId;

class PullRequestAchievementUnlocker
{
    public function achievementToBeUnlocked(
        int $pullRequestCount,
        UserExperienceId $userExperienceId
    ): ?Achievement {
        return Achievement::forPullRequest()
            ->get()
            ->filter(fn (Achievement $achievement) => $achievement->data['count_requirement'] <= $pullRequestCount)
            ->reject(fn(Achievement $achievement) => $achievement->receivedBy($userExperienceId))
            ->first();
    }
}
