<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class SignedProductLicenseController
{
    public function __invoke(Product $product, string $licenseKey)
    {
        /** @var \App\Models\License $license */
        $license = License::query()
            ->where('key', $licenseKey)
            ->whereHas('purchasable.product', function (Builder $query) use ($product) {
                $query->where('id', $product->id);
            })
            ->firstOrFail();

        return response()->json($license->signed_license);
    }
}
