<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\Purchasable;
use Illuminate\Http\Request;

class PriceController
{
    public function __invoke(Request $request, Purchasable $purchasable, ?string $ipOrCountryCode = null)
    {
        $ipOrCountryCode ??= $request->ip() ?? '';

        $countryCode = strlen($ipOrCountryCode) === 2
            ? $ipOrCountryCode
            : geoip($ipOrCountryCode)->iso_code;

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
