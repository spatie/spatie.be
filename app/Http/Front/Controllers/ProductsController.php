<?php

namespace App\Http\Front\Controllers;

use App\Models\Contributor;
use App\Models\Issue;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController
{
    public function index(Request $request)
    {
        $products = Product::orderBy('sort_order')->get();

        $purchases = optional($request->user())->purchases;

        return view('front.pages.products.index', compact('products', 'purchases'));
    }

    public function show(Product $product)
    {
        return view('front.pages.products.show', compact('product'));
    }
}
