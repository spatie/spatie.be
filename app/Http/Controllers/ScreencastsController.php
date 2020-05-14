<?php

namespace App\Http\Controllers;

use App\Models\Screencast;
use App\Models\Series;

class ScreencastsController extends Controller
{
    public function index()
    {
        $screencast = Screencast::first();

        return redirect()->action([ScreencastsController::class, 'show'], [$screencast->series, $screencast]);
    }

    public function show(Series $series, Screencast $screencast)
    {
        $allSeries = Series::with('screencasts')->get();

        $previousScreencast = $screencast->getPrevious();
        $nextScreencast = $screencast->getNext();
        $currentScreencast = $screencast;

        $title = $currentScreencast->title;
        $description = $currentScreencast->description;

        return view('screencasts.show', compact(
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
