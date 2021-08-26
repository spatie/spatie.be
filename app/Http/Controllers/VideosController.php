<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Video;

class VideosController
{
    public function index()
    {
        $seriesQuery = Series::with(['purchasables', 'videos'])
            ->orderBy('sort_order');

        if (! auth()->user()?->isSpatieMember()) {
            $seriesQuery->where('visible', true);
        }

        return view('front.pages.videos.index', [
            'allSeries' => $seriesQuery->get(),
        ]);
    }

    public function show(Series $series, Video $video)
    {
        $previousVideo = $video->getPrevious();
        $nextVideo = $video->getNext();
        $currentVideo = $video;

        $title = $currentVideo->title;
        $description = $currentVideo->description;

        $series->load(['purchasables.product']);

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
