<?php

namespace App\Domain\Experience;

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Commands\RegisterSeriesCompletion;
use App\Domain\Experience\Commands\RegisterVideoCompletion;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Events\PullRequestMerged;
use App\Domain\Experience\Events\SeriesCompleted;
use App\Domain\Experience\Events\VideoCompleted;
use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Exception;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class ExperienceAggregateRoot extends AggregateRoot
{
    public function addExperience(AddExperience $command): self
    {
        $this->recordThat(new ExperienceEarned(
            userId: $command->userId,
            amount: $command->amount,
        ));

        return $this;
    }

    public function unlockAchievement(UnlockAchievement $command): self
    {
        $this->recordThat(new AchievementUnlocked(
            userId: $command->userId,
            achievementId: $command->achievement->id,
            slug: $command->achievement->slug,
            title: $command->achievement->title,
            description: $command->achievement->description,
        ));

        return $this;
    }

    public function registerPullRequest(RegisterPullRequest $command): self
    {
        $this->recordThat(new PullRequestMerged(
            userId: $command->userId,
            reference: $command->reference,
        ));

        return $this;
    }

    public function registerVideoCompletion(RegisterVideoCompletion $command): self
    {
        $video = Video::query()->findOrFail($command->videoId);

        $this->recordThat(new VideoCompleted(
            userId: $command->userId,
            videoId: $command->videoId,
            seriesId: $video->series_id,
        ));

        return $this;
    }

    public function registerSeriesCompletion(RegisterSeriesCompletion $command): self
    {
        $user = User::query()->findOrFail($command->userId);

        $series = Series::query()->findOrFail($command->seriesId);

        if (! $user->hasCompleted($series)) {
            throw new Exception("Series was not completed");
        }

        $this->recordThat(new SeriesCompleted(
            userId: $command->userId,
            seriesId: $command->seriesId,
        ));

        return $this;
    }
}
