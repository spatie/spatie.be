<?php

namespace App\Http\Front\Controllers;

use App\Models\Contributor;
use App\Models\Issue;
use App\Models\Product;

class ProductsController
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->get();

        return view('front.pages.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('front.pages.products.show', compact('product'));
    }
}
