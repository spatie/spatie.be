<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController
{
    public function index(Request $request)
    {
        $products = Product::orderBy('sort_order')->get();

        if ($request->user()) {
            $purchasesPerProduct = $request->user()
                ->purchases()
                ->get()
                ->groupBy('purchasable.product_id');
        }

        return view('front.pages.products.index', compact('products', 'purchasesPerProduct'));
    }

    public function show(Request $request, Product $product)
    {
        if ($request->user()) {
            $purchases = $request->user()
                ->purchases()
                ->forProduct($product)
                ->get();
        }

        return view('front.pages.products.show', compact('product', 'purchases'));
    }
}
