<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Product;

class ShowReleaseNotesController
{
    public function __invoke(Product $product)
    {
        $releases = $product
            ->releases()
            ->where('released', true)
            ->orderByDesc('released_at')
            ->get();

        return view('front.pages.products.release-notes.show', compact('product', 'releases'));
    }
}
