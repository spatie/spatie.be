<?php

namespace App\Domain\Experience\Handlers;

use App\Domain\Experience\Commands\RegisterVideoCompletion;
use App\Domain\Experience\ExperienceAggregateRoot;
use App\Models\Series;
use App\Models\User;

class VideoCompletionHandler
{
    public function __invoke(RegisterVideoCompletion $command): void
    {
        $user = User::query()->findOrFail($command->userExperienceId->userId);

        $series = Series::query()->findOrFail($command->seriesId);

        $aggregateRoot = ExperienceAggregateRoot::retrieve($command->uuid);

        $aggregateRoot->registerVideoCompletion(
            userExperienceId: $command->userExperienceId,
            videoId: $command->videoId,
            seriesId: $command->seriesId,
        )->persist();

        if ($user->hasCompleted($series)) {
            $aggregateRoot->registerSeriesCompletion(
                userExperienceId: $command->userExperienceId,
                seriesId: $command->seriesId,
            )->persist();
        }
    }
}
