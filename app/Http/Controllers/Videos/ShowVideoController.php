<?php

namespace App\Http\Controllers\Videos;

use App\Models\Video;
use App\Models\Series;

class ShowVideoController
{
    public function __invoke(Series $series, Video $screencast)
    {
        $allSeries = Series::with('videos')->get();

        $previousScreencast = $screencast->getPrevious();
        $nextScreencast = $screencast->getNext();
        $currentScreencast = $screencast;

        $title = $currentScreencast->title;
        $description = $currentScreencast->description;

        return view('videos.show', compact(
            'title',
            'description',
            'allSeries',
            'series',
            'currentScreencast',
            'previousScreencast',
            'nextScreencast',
        ));
    }
}