<?php

namespace App\Domain\Achievements\Unlockers;

use App\Domain\Achievements\SeriesCompletionAchievement;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use App\Models\Series;

class SeriesCompletionAchievementUnlocker
{
    public function achievementToBeUnlocked(
        Series $series,
        UserExperienceId $userExperienceId,
    ): ?SeriesCompletionAchievement {
        $user = $userExperienceId->getUser();

        $achievement = new SeriesCompletionAchievement($series);

        if ($user->hasAchievement($achievement)) {
            return null;
        }

        if (! $achievement->canBeUnlocked($user)) {
            return null;
        }

        return $achievement;
    }
}
