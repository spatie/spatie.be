<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController
{
    public function index(Request $request)
    {
        $products = Product::orderBy('sort_order')->get();

        $purchasesPerProduct = collect();
        if ($request->user()) {
            $purchasesPerProduct = $request->user()
                ->purchasesWithoutRenewals()
                ->get()
                ->groupBy('purchasable.product_id');
        }

        return view('front.pages.products.index', compact('products', 'purchasesPerProduct'));
    }

    public function show(Request $request, Product $product)
    {
        $purchases = $licenses = collect();

        if ($request->user()) {
            $purchases = $request->user()
                ->purchasesWithoutRenewals()
                ->forProduct($product)
                ->get();

            $licenses = $request->user()
                ->licensesWithoutRenewals()
                ->with(['purchasable'])
                ->forProduct($product)
                ->get();
        }

        return view('front.pages.products.show', compact('product', 'purchases', 'licenses'));
    }
}
