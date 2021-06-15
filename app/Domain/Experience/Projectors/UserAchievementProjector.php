<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Projections\UserAchievementProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserAchievementProjector extends Projector
{
    public function onExperienceEarned(AchievementUnlocked $event): void
    {
        UserAchievementProjection::new()
            ->writeable()
            ->create([
                'email' => $event->email,
                'user_id' => $event->userId,
                'title' => $event->title,
            ]);
    }
}
