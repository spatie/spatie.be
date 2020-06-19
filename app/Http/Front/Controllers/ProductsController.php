<?php

namespace App\Http\Front\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductsController
{
    public function index(Request $request)
    {
        $products = Product::orderBy('sort_order')->get();

        $purchases = $request->user()
            ? Purchase::with('purchasable.product')->whereUser($request->user())->get()
            : [];

        return view('front.pages.products.index', compact('products', 'purchases'));
    }

    public function show(Product $product)
    {
        return view('front.pages.products.show', compact('product'));
    }
}
