<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->unless(
                current_user()?->hasAccessToUnReleasedProducts(),
                fn (Builder $query) => $query->where('visible', true)
            )
            ->orderBy('sort_order')
            ->get();

        $bundles = Bundle::orderBy('sort_order')
            ->unless(
                current_user()?->hasAccessToUnReleasedProducts(),
                fn (Builder $query) => $query->where('visible', true)
            )
            ->where('visible', true)
            ->get();

        return view('front.pages.products.index', compact('products', 'bundles'));
    }

    public function show(Request $request, Product $product)
    {
        if (! $product->visible && ! current_user()?->hasAccessToUnReleasedProducts()) {
            abort(404);
        }

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

    public function buy(Request $request, Product $product, Purchasable $purchasable, ?License $license = null)
    {
        if (! $purchasable->released) {
            if (! current_user()?->hasAccessToUnReleasedProducts()) {
                abort(404);
            }
        }

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
