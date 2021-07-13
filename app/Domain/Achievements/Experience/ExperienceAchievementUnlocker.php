<?php

namespace App\Domain\Achievements\Experience;

use App\Domain\Achievements\Models\Achievement;
use App\Domain\Experience\ValueObjects\UserExperienceId;

class ExperienceAchievementUnlocker
{
    public function achievementToBeUnlocked(
        int $previousCount,
        int $currentCount,
        UserExperienceId $userExperienceId
    ): ?Achievement {
        return Achievement::forExperience()
            ->get()
            ->filter(fn (Achievement $achievement) => $previousCount < $achievement->data['count_requirement'])
            ->filter(fn (Achievement $achievement) => $currentCount >= $achievement->data['count_requirement'])
            ->reject(fn (Achievement $achievement) => $achievement->receivedBy($userExperienceId))
            ->first();
    }
}
