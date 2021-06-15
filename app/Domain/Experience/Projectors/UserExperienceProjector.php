<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\ExperienceEarnedEvent;
use App\Domain\Experience\Projections\UserExperienceProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserExperienceProjector extends Projector
{
    public function onExperienceGained(ExperienceEarnedEvent $event): void
    {
        UserExperienceProjection::new()->writeable()
            ->create([
                'email' => $event->email,
                'user_id' => $event->userId,
                'amount' => $event->amount,
                'type' => $event->type,
            ]);
    }
}
