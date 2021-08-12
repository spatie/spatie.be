<?php

namespace App\Domain\Experience\Observers;

use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Enums\AchievementType;
use App\Models\Series;

class SeriesAchievementsObserver
{
    public function saved(Series $series): void
    {
        if (Achievement::forSeries($series)->exists()) {
            return;
        }

        Achievement::create([
            'slug' => $series->getAchievementSlug(),
            'title' => "{$series->title} completed!",
            'description' => "You've watched all videos in {$series->title}",
            'type' => AchievementType::Series(),
            'data' => ['series_id' => $series->id],
            'certificate_template_path' => 'front.achievements.certificatePlaceholder',
        ]);
    }
}
