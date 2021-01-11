<?php

namespace App\Http\Controllers;

use App\Models\Insight;

class BlogsController
{
    public function index()
    {
        $insights = Insight::orderBy('created_at', 'DESC')->paginate(2);

        return view('front.pages.blog.index', ['posts' => $insights]);
    }
}
