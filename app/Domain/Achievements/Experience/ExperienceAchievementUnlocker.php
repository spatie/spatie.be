<?php

namespace App\Domain\Achievements\Experience;

use App\Domain\Achievements\Models\Achievement;

class ExperienceAchievementUnlocker
{
    public function achievementToBeUnlocked(
        int $previousCount,
        int $currentCount,
        int $userId,
    ): ?Achievement {
        return Achievement::forExperience()
            ->get()
            ->filter(fn (Achievement $achievement) => $previousCount < $achievement->data['count_requirement'])
            ->filter(fn (Achievement $achievement) => $currentCount >= $achievement->data['count_requirement'])
            ->reject(fn (Achievement $achievement) => $achievement->receivedBy($userId))
            ->first();
    }
}
