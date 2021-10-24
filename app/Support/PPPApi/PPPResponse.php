<?php

namespace App\Support\PPPApi;

class PPPResponse
{
    public string $currencyCode;

    public ?string $currencySymbol;

    public float $exchangeRate;

    public float $conversionFactor;

    public static function create(array $properties): self
    {
        $currencyCode = array_key_first($properties['ppp']['currenciesCountry']);

        return new static(
            $currencyCode,
            $properties['ppp']['currencyMain']['symbol'] ?? $currencyCode,
            $properties['ppp']['currencyMain']['exchangeRate'],
            $properties['ppp']['pppConversionFactor'],
        );
    }

    public function __construct(
        string $currencyCode,
        ?string $currencySymbol,
        float $exchangeRate,
        float $conversionFactor
    ) {
        $this->currencyCode = $currencyCode;

        $this->currencySymbol = $currencySymbol;

        $this->exchangeRate = $exchangeRate;

        $this->conversionFactor = $conversionFactor;
    }

    public function priceForUsdAmount(int $amountInUsdCents): int
    {
        $amountInUsd = $amountInUsdCents / 100;

        $pppAmount = $amountInUsd * $this->exchangeRate * $this->conversionFactor;

        return (int) $pppAmount * 100;
    }
}
