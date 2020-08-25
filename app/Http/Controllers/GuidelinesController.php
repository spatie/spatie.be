<?php

namespace App\Http\Controllers;

use App\Guidelines\Guidelines;

class GuidelinesController
{
    public function index(Guidelines $guidelines)
    {
        $pages = $guidelines->pages();

        return view('front.pages.guidelines.index', compact('pages'));
    }

    public function show(string $slug, Guidelines $guidelines)
    {
        $page = $guidelines->page($slug);

        abort_unless($page, 404);

        return view('front.pages.guidelines.show', compact('page'));
    }
}
