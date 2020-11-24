<?php

namespace App\Http\Api\Controllers;

use App\Models\Purchasable;
use App\Models\PurchasablePrice;

class PurchasablePriceController
{
    public function __invoke(Purchasable $purchasable, string $countryCode)
    {
        $purchasablePrice = PurchasablePrice::firstWhere([
            'purchasable_id' => $purchasable->id,
            'country_code' => $countryCode,
        ]);

        if (! $purchasablePrice) {
            return response()->json([
                'currency' => 'USD',
                'price' => $purchasable->price_in_usd_cents,
            ]);
        }

        return response()->json([
            'currency' => $purchasablePrice->currency_code,
            'price' => $purchasablePrice->amount,
        ]);
    }
}
