<?php

namespace App\Http\Controllers;

use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\Series;

class SeriesController
{
    public function show(Series $series)
    {
        $title = $series->title;
        $description = $series->description;

        $series->load(['purchasables.product']);

        return view('front.pages.videos.series', compact(
            'title',
            'description',
            'series',
        ));
    }

    public function completed(Series $series)
    {
        $title = $series->title;
        $description = $series->description;

        $series->load(['purchasables.product']);

        $achievement = null;

        if ($user = current_user()) {
            $achievement = UserAchievementProjection::query()
                ->forUser($user->id)
                ->andSlug($series->getAchievementSlug())
                ->first();
        }

        return view('front.pages.videos.seriesCompleted', compact(
            'title',
            'description',
            'series',
            'achievement'
        ));
    }
}
