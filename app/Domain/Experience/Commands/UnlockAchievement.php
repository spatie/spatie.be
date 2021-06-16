<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\Achievements\Achievement;
use App\Domain\Experience\Achievements\ExperienceAchievement;
use App\Domain\Experience\Achievements\PullRequestAchievement;
use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class UnlockAchievement
{
    public function __construct(
        #[AggregateUuid] public string $uuid,
        public UserExperienceId $userExperienceId,
        public ExperienceAchievement|PullRequestAchievement $achievement,
    ) {
    }
}
