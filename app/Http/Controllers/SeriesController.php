<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\View\View;

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
