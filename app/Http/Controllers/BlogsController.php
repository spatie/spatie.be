<?php

namespace App\Http\Controllers;

use App\Models\Insight;

class BlogsController
{
    public function index()
    {
        $insights = Insight::getLatest();

        return view('front.pages.blog.index', ['posts' => $insights]);
    }
}
