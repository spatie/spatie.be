<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use Illuminate\Http\Request;

class ProductsController
{
    public function index(Request $request)
    {
        $products = Product::orderBy('sort_order')
            ->where('visible', true)
            ->get();

        $bundles = Bundle::orderBy('sort_order')
            ->where('visible', true)
            ->get();

        return view('front.pages.products.index', compact('products', 'bundles'));
    }

    public function show(Request $request, Product $product)
    {
        $assignments = $licenses = collect();

        if ($request->user()) {
            $assignments = $request->user()
                ->assignments()
                ->with(['licenses', 'purchasable.product'])
                ->forProduct($product)
                ->get();

            $licenses = $assignments->flatMap(function (PurchaseAssignment $assignment) {
                return $assignment->licenses->map(function (License $license) use ($assignment) {
                    $license->setRelation('assignment', $assignment);
                    return $license;
                });
            });
        }

        return view('front.pages.products.show', compact('product', 'assignments', 'licenses'));
    }

    public function buy(Request $request, Product $product, Purchasable $purchasable, License $license = null)
    {
        if (! $product->purchasables->contains($purchasable)) {
            abort(404);
        }

        if (! auth()->check()) {
            return redirect(route('login') . "?next=" . route('products.buy', [$product, $purchasable]));
        }

        $payLink = auth()->user()->getPayLinkForProductId(
            $purchasable->paddle_product_id,
            $license
        );

        return view('front.pages.products.buy', compact('product', 'purchasable', 'license', 'payLink'));
    }
}
