<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Projections\UserExperienceProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserExperienceProjector extends Projector
{
    public function onExperienceEarned(ExperienceEarned $event): void
    {
        UserExperienceProjection::new()
            ->writeable()
            ->create([
                'user_id' => $event->userId,
                'amount' => $event->amount,
            ]);
    }
}
