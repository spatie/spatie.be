<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Achievements\Experience\ExperienceAchievement;
use App\Domain\Achievements\Models\Achievement;
use App\Domain\Achievements\PullRequest\PullRequestAchievement;
use App\Domain\Achievements\Series\SeriesCompletionAchievement;
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
        public Achievement $achievement,
    ) {
    }
}
