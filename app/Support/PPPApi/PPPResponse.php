<?php

namespace App\Support\PPPApi;

class PPPResponse
{
    public string $currencyCode;

    public float $exchangeRate;

    public float $conversionFactor;

    public static function create(array $properties): self
    {
        return new static(
            $properties['ppp']['currencyMain']['code'],
            $properties['ppp']['currencyMain']['exchangeRate'],
            $properties['ppp']['pppConversionFactor'],
        );
    }

    public function __construct(string $currencyCode, float $exchangeRate, float $conversionFactor)
    {
        $this->currencyCode = $currencyCode;

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
