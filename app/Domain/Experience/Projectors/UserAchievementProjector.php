<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Projections\UserAchievementProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserAchievementProjector extends Projector
{
    public function onExperienceEarned(AchievementUnlocked $event): void
    {
        UserAchievementProjection::new()
            ->writeable()
            ->create([
                'email' => $event->userExperienceId->email,
                'user_id' => $event->userExperienceId->userId,
                'achievement_id' => $event->achievementId,
                'slug' => $event->slug,
                'title' => $event->title,
                'description' => $event->description,
            ]);
    }
}
