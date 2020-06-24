<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductsController
{
    public function index(Request $request)
    {
        $products = Product::orderBy('sort_order')->get();

        $purchasesPerProduct = $this->getPurchasesPerProduct();

        return view('front.pages.products.index', compact('products', 'purchasesPerProduct'));
    }

    protected function getPurchasesPerProduct(): Collection
    {
        if (! request()->user()) {
            return collect();
        }

        return Purchase::with('purchasable.product')->whereUser(request()->user())->get()->groupBy('purchasable.product_id');
    }

    public function show(Product $product)
    {
        return view('front.pages.products.show', compact('product'));
    }
}
