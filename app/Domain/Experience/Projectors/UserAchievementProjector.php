<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Events\UserDeleted;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Support\Uuid\Uuid;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserAchievementProjector extends Projector
{
    public function onExperienceEarned(AchievementUnlocked $event): void
    {
        UserAchievementProjection::new()
            ->writeable()
            ->create([
                'uuid' => (string) Uuid::new(),
                'user_id' => $event->userId,
                'achievement_id' => $event->achievementId,
                'slug' => $event->slug,
                'title' => $event->title,
                'description' => $event->description,
            ]);
    }

    public function onUserDeleted(UserDeleted $event): void
    {
        UserAchievementProjection::query()
            ->where('user_id', $event->userId)
            ->delete();
    }
}
