<?php

namespace App\Http\Controllers;

use App\Models\ExternalFeedItem;
use Illuminate\View\View;

class BlogsController
{
    public function index(): View
    {
        $insights = ExternalFeedItem::orderBy('created_at', 'DESC')->paginate(10);

        return view('front.pages.blog.index', ['posts' => $insights]);
    }
}
