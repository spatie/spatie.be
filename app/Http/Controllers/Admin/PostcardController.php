<?php

namespace App\Http\Controllers\Admin;

use App\Models\Postcard;
use Illuminate\Http\Request;

class PostcardController
{
    public function index()
    {
        $postcards = Postcard::latest()->get();

        return view('admin.postcard', compact('postcards'));
    }

    public function store(Request $request)
    {
        $postcard = Postcard::create($request->only(['sender', 'city', 'country']));

        $postcard
            ->addMedia($request->file('image'))
            ->withResponsiveImages()
            ->toMediaCollection();

        return redirect()->back()->with('message', 'Postcard added!');
    }

    public function delete(Postcard $postcard)
    {
        $postcard->delete();

        return redirect()->back()->with('message', 'Postcard deleted!');
    }
}
