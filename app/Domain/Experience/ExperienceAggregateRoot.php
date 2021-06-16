<?php

namespace App\Domain\Experience;

use App\Domain\Experience\Achievements\ExperienceAchievementUnlocker;
use App\Domain\Experience\Achievements\PullRequestAchievementUnlocker;
use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Events\PullRequestMerged;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class ExperienceAggregateRoot extends AggregateRoot
{
    private int $experienceCount = 0;

    private int $pullRequestCount = 0;

    private PullRequestAchievementUnlocker $pullRequestAchievementUnlocker;

    private ExperienceAchievementUnlocker $experienceAchievementUnlocker;

    public function __construct()
    {
        $this->pullRequestAchievementUnlocker = new PullRequestAchievementUnlocker();
        $this->experienceAchievementUnlocker = new ExperienceAchievementUnlocker();
    }

    public function add(AddExperience $command): self
    {
        $previousCount = $this->experienceCount;

        $this->recordThat(new ExperienceEarned(
            id: $command->userExperienceId,
            amount: $command->amount,
        ));

        $currentCount = $this->experienceCount;

        $achievement = $this->experienceAchievementUnlocker->achievementToBeUnlocked(
            previousCount: $previousCount,
            currentCount: $currentCount,
            userExperienceId: $command->userExperienceId
        );

        if ($achievement) {
            $this->unlockAchievement(new UnlockAchievement(
                $this->uuid(),
                $command->userExperienceId,
                $achievement,
            ));
        }

        return $this;
    }

    protected function applyExperienceEarned(ExperienceEarned $event): void
    {
        $this->experienceCount += $event->amount;
    }

    public function unlockAchievement(UnlockAchievement $command): self
    {
        $this->recordThat(new AchievementUnlocked(
            id: $command->userExperienceId,
            slug: $command->achievement->slug,
            title: $command->achievement->title,
            description: $command->achievement->description,
        ));

        return $this;
    }

    public function registerPullRequest(RegisterPullRequest $command): self
    {
        $this->recordThat(new PullRequestMerged(
            id: $command->userExperienceId,
        ));

        $achievement = $this->pullRequestAchievementUnlocker->achievementToBeUnlocked(
            pullRequestCount: $this->pullRequestCount,
            userExperienceId: $command->userExperienceId,
        );

        if ($achievement) {
            $this->unlockAchievement(new UnlockAchievement(
                uuid: $this->uuid(),
                userExperienceId: $command->userExperienceId,
                achievement: $achievement,
            ));
        }

        return $this;
    }

    protected function applyPullRequestMerged(PullRequestMerged $event): void
    {
        $this->pullRequestCount++;
    }
}
