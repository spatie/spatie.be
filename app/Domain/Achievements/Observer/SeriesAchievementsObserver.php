<?php

namespace App\Domain\Achievements\Observer;

use App\Domain\Achievements\Models\Achievement;
use App\Domain\Achievements\States\SeriesAchievementType;
use App\Models\Series;

class SeriesAchievementsObserver
{
    public function saved(Series $series): void
    {
        if (Achievement::forSeries($series)->exists()) {
            return;
        }

        Achievement::create([
            'slug' => "series-completed-{$series->id}",
            'title' => "{$series->title} completed!",
            'description' => "You've watched all videos in {$series->title}",
            'type' => SeriesAchievementType::class,
            'data' => ['series_id' => $series->id],
        ]);
    }
}
