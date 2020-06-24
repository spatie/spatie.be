<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Video;

class VideosController
{
    public function index()
    {
        return view('front.pages.videos.index', [
            'allSeries' => Series::get(),
        ]);
    }

    public function show(Series $series, Video $video)
    {
        $previousVideo = $video->getPrevious();
        $nextVideo = $video->getNext();
        $currentVideo = $video;

        $title = $currentVideo->title;
        $description = $currentVideo->description;

        return view('front.pages.videos.show', compact(
            'title',
            'description',
            'series',
            'currentVideo',
            'previousVideo',
            'nextVideo',
        ));
    }
}
