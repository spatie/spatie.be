<?php

namespace App\Http\Controllers;

use App\Guidelines\Guidelines;
use Illuminate\View\View;

class GuidelinesController
{
    public function index(Guidelines $guidelines): View
    {
        $pages = $guidelines->pages();

        return view('front.pages.guidelines.index', compact('pages'));
    }

    public function show(string $slug, Guidelines $guidelines): View
    {
        $page = $guidelines->page($slug);

        abort_unless($page, 404);

        return view('front.pages.guidelines.show', compact('page'));
    }
}
