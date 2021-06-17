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
use App\Domain\Experience\Events\SeriesCompleted;
use App\Domain\Experience\Events\VideoCompleted;
use App\Domain\Experience\ValueObjects\UserExperienceId;
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
            userExperienceId: $command->userExperienceId,
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
            userExperienceId: $command->userExperienceId,
            slug: $command->achievement->slug,
            title: $command->achievement->title,
            description: $command->achievement->description,
        ));

        return $this;
    }

    public function registerPullRequest(RegisterPullRequest $command): self
    {
        $this->recordThat(new PullRequestMerged(
            userExperienceId: $command->userExperienceId,
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

    public function registerVideoCompletion(
        UserExperienceId $userExperienceId,
        int $videoId,
        int $seriesId,
    ): self {
        $this->recordThat(new VideoCompleted(
            $userExperienceId,
            $videoId,
            $seriesId,
        ));

        return $this;
    }

    public function registerSeriesCompletion(
        UserExperienceId $userExperienceId,
        int $seriesId,
    ): self {
        $this->recordThat(new SeriesCompleted(
            $userExperienceId,
            $seriesId,
        ));

        return $this;
    }
}
