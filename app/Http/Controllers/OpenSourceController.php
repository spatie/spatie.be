<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Product;

class OpenSourceController
{
    public function packages()
    {
        return view('front.pages.open-source.packages');
    }

    public function projects()
    {
        return view('front.pages.open-source.projects');
    }

    public function support()
    {
        $contributor = Contributor::first();

        $products = Product::orderBy('sort_order')->get();

        return view('front.pages.open-source.support', [
            'contributor' => $contributor,
            'products' => $products,
        ]);
    }
}
