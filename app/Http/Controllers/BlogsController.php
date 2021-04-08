<?php

namespace App\Http\Controllers;

use App\Models\Insight;

class BlogsController
{
    public function index()
    {
        ray()->showQueries();

        $insights = Insight::orderBy('created_at', 'DESC')->paginate(10);

        return view('front.pages.blog.index', ['posts' => $insights]);
    }
}
