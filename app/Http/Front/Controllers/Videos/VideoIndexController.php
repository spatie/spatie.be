<?php

namespace App\Http\Front\Controllers\Videos;

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
