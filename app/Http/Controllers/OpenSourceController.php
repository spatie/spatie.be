<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class OpenSourceController
{
    public function support(): View
    {
        $products = Product::query()
            ->unless(
                current_user()?->hasAccessToUnReleasedProducts(),
                fn (Builder $query) => $query->where('visible', true)
            )
            ->orderBy('sort_order')
            ->get();

        return view('front.pages.open-source.support', [
            'products' => $products,
        ]);
    }
}
