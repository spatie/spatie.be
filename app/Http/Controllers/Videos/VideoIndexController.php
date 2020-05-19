<?php

namespace App\Http\Controllers\Videos;

use App\Http\Controllers\Controller;
use App\Models\Series;

class VideoIndexController extends Controller
{
    public function __invoke()
    {
        return view('videos.index', [
            'allSeries' => Series::get(),
        ]);
    }
}
