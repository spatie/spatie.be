<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Domain\Shop\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class OpenSourceController
{
    public function packages(): View
    {
        return view('front.pages.open-source.packages');
    }

    public function projects(): View
    {
        return view('front.pages.open-source.projects');
    }

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

    public function testimonials(): View
    {
        return view('front.pages.open-source.testimonials');
    }
}
