<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Achievements\ExperienceAchievement;
use App\Domain\Achievements\PullRequestAchievement;
use App\Domain\Achievements\SeriesCompletionAchievement;
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
        public ExperienceAchievement|PullRequestAchievement|SeriesCompletionAchievement $achievement,
    ) {
    }
}
