<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Series;

class SeriesController
{
    public function show(Series $series): View
    {
        $title = $series->title;
        $description = $series->description;

        $series->load(['purchasables.product']);

        $lesson = $series->lessons()->first();

        return view('front.pages.courses.series', compact(
            'title',
            'description',
            'series',
            'lesson',
        ));
    }
}
