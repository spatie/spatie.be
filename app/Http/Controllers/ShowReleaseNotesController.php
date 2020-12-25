<?php

namespace App\Http\Controllers;

use App\Models\Product;

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
