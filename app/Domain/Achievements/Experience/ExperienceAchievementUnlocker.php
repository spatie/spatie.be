<?php

namespace App\Domain\Achievements\Experience;

use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Experience\ValueObjects\UserExperienceId;

class ExperienceAchievementUnlocker
{
    /**
     * @return \App\Domain\Achievements\Experience\ExperienceAchievement[]
     */
    private function getAchievements(): array
    {
        return [
            new ExperienceAchievement('100-experience', '100 XP', "You've collected 100 XP", 100),
            new ExperienceAchievement('1000-experience', '1000 XP', "You've collected 1000 XP", 1000),
            new ExperienceAchievement('10_000-experience', '10.000 XP', "You've collected 10.000 XP", 10_000),
            new ExperienceAchievement('100_000-experience', '100.000 XP', "You've collected 100.000 XP", 100_000),
        ];
    }

    public function achievementToBeUnlocked(
        int $previousCount,
        int $currentCount,
        UserExperienceId $userExperienceId
    ): ?ExperienceAchievement {
        foreach ($this->getAchievements() as $achievement) {
            if (! $achievement->matches($previousCount, $currentCount)) {
                continue;
            }

            if (UserAchievementProjection::forUser($userExperienceId)->andSlug($achievement->slug)->exists()) {
                continue;
            }

            return $achievement;
        }

        return null;
    }
}
