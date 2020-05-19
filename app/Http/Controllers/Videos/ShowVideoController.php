<?php

namespace App\Http\Controllers\Videos;

use App\Models\Screencast;
use App\Models\Series;

class ShowVideoController
{
    public function __invoke(Series $series, Screencast $screencast)
    {
        $allSeries = Series::with('screencasts')->get();

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