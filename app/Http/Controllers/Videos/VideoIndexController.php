<?php

namespace App\Http\Controllers\Videos;

use App\Models\Series;

class VideoIndexController
{
    public function __invoke()
    {
        return view('front.pages.videos.index', [
            'allSeries' => Series::get(),
        ]);
    }
}
