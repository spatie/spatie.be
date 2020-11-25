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

        $discountProperties = [];
        if ($purchasable->hasActiveDiscount()) {
            $discountProperties = [
                'discount_percentage' => $purchasable->discount_percentage,
                'discount_expires_at' => $purchasable->discount_expires_at->timestamp,
                'discount_name' => $purchasable->discount_name,
                'price_without_discount_in_usd_cents' => $purchasable->price_without_discount_in_usd_cents,
            ];
        }

        if (! $purchasablePrice) {
            return response()->json(array_merge($discountProperties, [
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'amount' => $purchasable->price_in_usd_cents,
            ]));
        }

        return response()->json(array_merge($discountProperties,[
            'currency_code' => $purchasablePrice->currency_code,
            'currency_symbol' => $purchasablePrice->currency_symbol,
            'price' => $purchasablePrice->amount,
        ]));
    }
}
