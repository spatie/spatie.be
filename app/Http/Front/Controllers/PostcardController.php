<?php

namespace App\Http\Front\Controllers;

use App\Models\Postcard;

class PostcardController
{
    public function index()
    {
        $postcards = Postcard::orderByDesc('created_at')->get();

        $countries = Postcard::getTopCountries();

        return view('pages.open-source.postcards', compact('postcards', 'countries'));
    }
}
