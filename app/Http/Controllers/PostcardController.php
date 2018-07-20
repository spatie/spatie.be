<?php

namespace App\Http\Controllers;

use App\Models\Postcard;

class PostcardController extends Controller
{
    public function index()
    {
        $postcards = Postcard::orderByDesc('created_at')->get();

        $countries = Postcard::getTopCountries();

        return view('pages.open-source.postcards', compact('postcards', 'countries'));
    }
}
