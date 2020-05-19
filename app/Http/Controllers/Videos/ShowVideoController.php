<?php

namespace App\Http\Controllers\Videos;

use App\Models\Video;
use App\Models\Series;

class ShowVideoController
{
    public function __invoke(Series $series, Video $video)
    {
        $allSeries = Series::with('videos')->get();

        $previousVideo = $video->getPrevious();
        $nextVideo = $video->getNext();
        $currentVideo = $video;

        $title = $currentVideo->title;
        $description = $currentVideo->description;

        return view('videos.show', compact(
            'title',
            'description',
            'allSeries',
            'series',
            'currentVideo',
            'previousVideo',
            'nextVideo',
        ));
    }
}