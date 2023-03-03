<?php

namespace App\Http\Controllers;

use App\Models\Postcard;
use Illuminate\View\View;

class PostcardController
{
    public function index(): View
    {
        $postcards = Postcard::orderByDesc('created_at')->get();

        $countries = Postcard::getTopCountries();

        return view('front.pages.open-source.postcards', compact('postcards', 'countries'));
    }
}
