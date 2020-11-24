<?php

namespace App\Support\Paddle;

use Illuminate\Support\Collection;

class EuCountries
{
    public static function get(): Collection
    {
        return collect([
            'BE',
        ]);
    }

    public static function contains(string $countryCode): bool
    {
        return static::get()->contains($countryCode);
    }
}
