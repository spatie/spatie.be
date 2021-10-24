<?php

namespace App\Support\PPPApi;

use Illuminate\Support\Facades\Http;

class PPPApi
{
    public static function fetchForCountryCode(string $countryCode): ?PPPResponse
    {
        $response = Http::get("https://api.purchasing-power-parity.com/?target={$countryCode}");

        if ($response->status() !== 200) {
            return null;
        }

        $rawResponse = $response->json();

        if (isset($rawResponse['message'])) {
            return null;
        }

        if (! array_key_first($rawResponse['ppp']['currenciesCountry'])) {
            return null;
        }

        return PPPResponse::create($rawResponse);
    }
}
