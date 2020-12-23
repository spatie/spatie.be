<?php

namespace App\Http\Api\Controllers;

use App\Models\Product;

class ShowReleaseController
{
    public function __invoke(Product $product, string $version)
    {
        $release = $product
            ->releases()
            ->where('released', true)
            ->firstWhere('version', $version);

        if (! $release) {
            abort(404);
        }

        return response()->json([
            'notes' => $release->notes_html,
        ]);
    }
}
