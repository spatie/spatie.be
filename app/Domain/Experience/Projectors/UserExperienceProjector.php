<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Events\UserDeleted;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Models\User;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserExperienceProjector extends Projector
{
    public function onExperienceEarned(ExperienceEarned $event): void
    {
        /** @var User $user */
        $user = User::find($event->userId);

        $userExperience = $user->experience;

        if (! $userExperience) {
            $userExperience = UserExperienceProjection::new()
                ->writeable()
                ->create([
                    'uuid' => $user->uuid,
                    'user_id' => $event->userId,
                    'amount' => 0,
                ]);
        }

        $userExperience->writeable()->update([
            'amount' => $userExperience->amount + $event->amount,
        ]);
    }

    public function onUserDeleted(UserDeleted $event): void
    {
        UserExperienceProjection::query()
            ->where('user_id', $event->userId)
            ->delete();
    }
}
