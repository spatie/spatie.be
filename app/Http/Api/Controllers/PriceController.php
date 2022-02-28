<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\Purchasable;

class PriceController
{
    public function __invoke(Purchasable $purchasable, string $countryCode)
    {
        $price = $purchasable->getPriceForCountryCode($countryCode);
        $priceWithoutDiscount = $purchasable->getPriceWithoutDiscountForCountryCode($countryCode);

        return response()->json([
           'actual' => [
               'price_in_cents' => $price->priceInCents,
               'currency_code' => $price->currencyCode,
               'currency_symbol' => $price->currencySymbol,
               'formatted_price' => $price->formattedPrice(),
           ],
            'without_discount' => [
                'price_in_cents' => $priceWithoutDiscount->priceInCents,
                'currency_code' => $priceWithoutDiscount->currencyCode,
                'currency_symbol' => $priceWithoutDiscount->currencySymbol,
                'formatted_price' => $priceWithoutDiscount->formattedPrice(),
            ],
            'discount' => [
                'active' => $purchasable->hasActiveDiscount(),
                'percentage' => $purchasable->discount_percentage,
                'name' => $purchasable->discount_name,
                'expires_at' => $purchasable->discount_expires_at?->timestamp,
            ],
        ]);
    }
}
