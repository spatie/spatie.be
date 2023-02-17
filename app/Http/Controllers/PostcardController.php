<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Postcard;

class PostcardController
{
    public function index(): View
    {
        $postcards = Postcard::orderByDesc('created_at')->get();

        $countries = Postcard::getTopCountries();

        return view('front.pages.open-source.postcards', compact('postcards', 'countries'));
    }
}
