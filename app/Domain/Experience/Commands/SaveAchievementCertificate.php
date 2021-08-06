<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\Projections\UserAchievementProjection;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class SaveAchievementCertificate
{
    public static function forUserAchievement(
        UserAchievementProjection $userAchievement
    ): self {
        return new self(
            $userAchievement->user->uuid,
            $userAchievement,
        );
    }

    public function __construct(
        #[AggregateUuid] public string $uuid,
        public UserAchievementProjection $userAchievement,
    ) {
    }
}
