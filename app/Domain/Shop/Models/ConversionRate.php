<?php

namespace App\Domain\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ConversionRate extends Model
{
    public static function forCountryCode(string $countryCode): ?self
    {
        return static::query()->firstWhere(['country_code' => $countryCode]);
    }

    public static function forCurrencyCode(string $currencyCode): ?self
    {
        return static::query()->firstWhere(['currency_code' => $currencyCode]);
    }

    public function getAmountForUsd(int $amountInCents): int
    {
        $priceInCents = (int) ($amountInCents * $this->exchange_rate * $this->ppp_conversion_factor);

        $roundedPriceInCents = round($priceInCents / 100) * 100;

        return $roundedPriceInCents;
    }

    public function getPPPInUsd(int $amountInCents): int
    {
        $priceInCents = (int) ($amountInCents * $this->ppp_conversion_factor);

        $roundedPriceInCents = round($priceInCents / 100) * 100;

        return $roundedPriceInCents;
    }
}
