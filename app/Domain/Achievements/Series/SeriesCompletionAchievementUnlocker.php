<?php

namespace App\Domain\Achievements\Series;

use App\Domain\Achievements\Series\SeriesCompletionAchievement;
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
