<?php

namespace App\Domain\Experience;

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Events\PullRequestMerged;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class ExperienceAggregateRoot extends AggregateRoot
{
    private int $amount = 0;

    private int $pullRequestCount = 0;

    public function add(AddExperience $command): self
    {
        $previousAmount = $this->amount;

        $this->recordThat(new ExperienceEarned(
            email: $command->getEmail(),
            userId: $command->getUserId(),
            amount: $command->getAmount(),
            type: $command->getType(),
        ));

        if ($previousAmount < 100 && $this->amount >= 100) {
            $this->unlockAchievement(new UnlockAchievement(
                $this->uuid(),
                $command->getEmail(),
                '100 XP!'
            ));
        }

        if ($previousAmount < 1000 && $this->amount >= 1000) {
            $this->unlockAchievement(new UnlockAchievement(
                $this->uuid(),
                $command->getEmail(),
                '1000 XP!'
            ));
        }

        return $this;
    }

    protected function applyExperienceEarned(ExperienceEarned $event): void
    {
        $this->amount += $event->amount;
    }

    public function unlockAchievement(UnlockAchievement $command): self
    {
        $this->recordThat(new AchievementUnlocked(
            email: $command->getEmail(),
            userId: $command->getUserId(),
            title: $command->getTitle(),
        ));

        return $this;
    }

    public function registerPullRequest(RegisterPullRequest $command): self
    {
        $this->recordThat(new PullRequestMerged(
            email: $command->getEmail(),
            userId: $command->getUserId(),
        ));

        if ($this->pullRequestCount === 10) {
            $this->unlockAchievement(new UnlockAchievement(
                $this->uuid(),
                $command->getEmail(),
                '10 PRs!'
            ));
        }

        if ($this->pullRequestCount === 100) {
            $this->unlockAchievement(new UnlockAchievement(
                $this->uuid(),
                $command->getEmail(),
                'Package master!'
            ));
        }

        return $this;
    }

    protected function applyPullRequestMerged(PullRequestMerged $event): void
    {
        $this->pullRequestCount++;
    }
}
