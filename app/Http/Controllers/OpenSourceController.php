<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class OpenSourceController
{
    public function packages()
    {
        return view('front.pages.open-source.packages');
    }

    public function projects()
    {
        return view('front.pages.open-source.projects');
    }

    public function support()
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

    public function testimonials()
    {
        return view('front.pages.open-source.testimonials');
    }
}
