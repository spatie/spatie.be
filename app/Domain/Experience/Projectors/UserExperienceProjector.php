<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\ExperienceGainedEvent;
use App\Domain\Experience\Projections\UserExperienceProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserExperienceProjector extends Projector
{
    public function onExperienceGained(ExperienceGainedEvent $event): void
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
