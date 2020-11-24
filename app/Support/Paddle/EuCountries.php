<?php

namespace App\Support\Paddle;

use Illuminate\Support\Collection;

class EuCountries
{
    public static function get(): Collection
    {
        return collect([
            'AT',
            'BE',
            'BG',
            'CY',
            'CZ',
            'DE',
            'DK',
            'EE',
            'ES',
            'FI',
            'FR',
            'GR',
            'HR',
            'HU',
            'IE',
            'IT',
            'LU',
            'LV',
            'MT',
            'NL',
            'PO',
            'PT',
            'RO',
            'SE',
            'SI',
            'SK',
            'NO',
            'CH',
        ]);
    }

    public static function contains(string $countryCode): bool
    {
        return static::get()->contains($countryCode);
    }
}
