<?php

namespace App\Domain\Achievements\Series;

use App\Domain\Achievements\Models\Achievement;
use App\Models\Series;
use App\Models\User;

class SeriesCompletionAchievementUnlocker
{
    public function achievementToBeUnlocked(
        Series $series,
        int $userId,
    ): ?Achievement {
        $user = User::find($userId);

        $achievement = Achievement::forSeries($series)->first();

        if (! $achievement) {
            return null;
        }

        if ($achievement->receivedBy($userId)) {
            return null;
        }

        if (! $user->hasCompleted($series)) {
            return null;
        }

        return $achievement;
    }
}
