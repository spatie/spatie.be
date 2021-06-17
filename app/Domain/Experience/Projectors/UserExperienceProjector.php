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
                'email' => $event->userExperienceId->email,
                'user_id' => $event->userExperienceId->userId,
                'amount' => $event->amount,
            ]);
    }
}
