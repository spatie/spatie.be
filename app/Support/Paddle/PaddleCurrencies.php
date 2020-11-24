<?php

namespace App\Support\Paddle;

use Illuminate\Support\Collection;

class PaddleCurrencies
{
    public static function get(): Collection
    {
        return collect([
            'USD',
            'EUR',
            'GBP',
            'ARS',
            'AUD',
            'CAD',
            'CHF',
            'CZK',
            'HKD',
            'HUF',
            'INR',
            'ILS',
            'JPY',
            'KRW',
            'MXN',
            'NOK',
            'NZD',
            'PLN',
            'RUB',
            'SEK',
            'SGD',
            'THB',
            'TRY',
            'TWD',
            'UAH',
            'BRL',
            'CNY',
            'ZAR',
        ]);
    }

    public static function contains(string $currency): bool
    {
        return static::get()->contains($currency);
    }
}
