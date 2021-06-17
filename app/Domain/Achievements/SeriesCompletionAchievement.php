<?php

namespace App\Domain\Achievements;

use App\Models\Series;
use App\Models\User;

class SeriesCompletionAchievement
{
    public string $slug;

    public string $title;

    public string $description;

    public function __construct(
        public Series $series,
    ) {
        $this->slug = "series-completed-{$this->series->id}";
        $this->title = "Videos for \"{$this->series->title}\" completed!";
        $this->description = "You've watched all videos in the \"{$this->series->title}\" course.";
    }

    public function canBeUnlocked(User $user): bool
    {
        return $user->hasCompleted($this->series);
    }
}
