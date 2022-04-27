<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\Bundle;

class BundlePriceController
{
    public function __invoke(Bundle $bundle, string $ipOrCountryCode)
    {
        $countryCode = strlen($ipOrCountryCode) === 2
            ? $ipOrCountryCode
            : geoip($ipOrCountryCode)->iso_code;

        $price = $bundle->getPriceForCountryCode($countryCode);
        $priceWithoutDiscount = $bundle->getPriceWithoutDiscountForCountryCode($countryCode);

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
                'active' => $bundle->hasActiveDiscount(),
                'percentage' => $bundle->discount_percentage,
                'name' => $bundle->discount_name,
                'expires_at' => $bundle->discount_expires_at?->timestamp,
            ],
        ]);
    }
}
