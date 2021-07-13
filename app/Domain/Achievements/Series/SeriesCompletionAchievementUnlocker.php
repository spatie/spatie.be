<?php

namespace App\Domain\Achievements\Series;

use App\Domain\Achievements\Models\Achievement;
use App\Domain\Achievements\States\SeriesAchievementType;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use App\Models\Series;
use Exception;

class SeriesCompletionAchievementUnlocker
{
    public function achievementToBeUnlocked(
        Series $series,
        UserExperienceId $userExperienceId,
    ): ?Achievement {
        $user = $userExperienceId->getUser();

        $achievement = Achievement::forSeries($series)->first();

        if (! $achievement) {
            return null;
        }

        if ($achievement->receivedBy($userExperienceId)) {
            return null;
        }

        if (! $user->hasCompleted($series)) {
            return null;
        }

        return $achievement;
    }
}
