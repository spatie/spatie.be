<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\User;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class SaveAchievementOgImage
{
    public static function forUser(
        User $user,
        UserAchievementProjection $userAchievement,
        string $imagePath,
    ): self {
        return new self(
            $user->uuid,
            $userAchievement->uuid,
            $imagePath,
        );
    }

    public function __construct(
        #[AggregateUuid] public string $uuid,
        public string $userAchievementUuid,
        public string $imagePath,
    ) {
    }
}
