<?php

namespace App\Domain\Experience\Achievements;

use App\Domain\Experience\Models\Achievement;
use App\Models\User;
use Spatie\EventSourcing\Handlers;

class AchievementResolver
{
    public function handle(object $command): ?Achievement
    {
        $handler = Handlers::find($command, $this)[0] ?? null;

        if (! $handler) {
            return null;
        }

        return $this->{$handler}($command);
    }

    public function forExperience(ExperienceAchievement $command): ?Achievement
    {
        return Achievement::forExperience()
            ->get()
            ->filter(fn (Achievement $achievement) => $command->previousCount < $achievement->data['count_requirement'])
            ->filter(fn (Achievement $achievement) => $command->currentCount >= $achievement->data['count_requirement'])
            ->reject(fn (Achievement $achievement) => $achievement->receivedBy($command->userId))
            ->first();
    }

    public function forPullRequest(PullRequestAchievement $command): ?Achievement
    {
        return Achievement::forPullRequest()
            ->get()
            ->filter(fn (Achievement $achievement) => $achievement->data['count_requirement'] <= $command->pullRequestCount)
            ->reject(fn(Achievement $achievement) => $achievement->receivedBy($command->userId))
            ->first();
    }

    public function forSeries(SeriesAchievement $command): ?Achievement
    {
        $achievement = Achievement::forSeries($command->series)->first();

        if (! $achievement) {
            return null;
        }

        if ($achievement->receivedBy($command->userId)) {
            return null;
        }

        $user = User::find($command->userId);

        if (! $user->hasCompleted($command->series)) {
            return null;
        }

        return $achievement;
    }
}
