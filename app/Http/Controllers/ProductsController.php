<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Product;
use App\Models\Purchasable;
use Illuminate\Http\Request;

class ProductsController
{
    public function index(Request $request)
    {
        $products = Product::orderBy('sort_order')
            ->where('visible', true)
            ->get();

        return view('front.pages.products.index', compact('products'));
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

    public function buy(Request $request, Product $product, Purchasable $purchasable, License $license = null)
    {
        if (! $product->purchasables->contains($purchasable)) {
            abort(404);
        }

        $payLink = auth()->user()->getPayLinkForProductId(
            $purchasable->paddle_product_id,
            $license
        );

        return view('front.pages.products.buy', compact('product', 'purchasable', 'license', 'payLink'));
    }
}
