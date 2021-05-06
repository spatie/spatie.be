<?php

namespace App\Support;

use Illuminate\Support\Str;

class DisplayablePrice
{
    public int $priceInCents;
    public string $currencyCode;
    public ?string $currencySymbol;

    public function __construct(
        int $priceInCents,
        string $currencyCode,
        ?string $currencySymbol = null
    ) {
        $this->priceInCents = $priceInCents;
        $this->currencyCode = $currencyCode;
        $this->currencySymbol = $currencySymbol;
    }

    public function toPaddleFormat(): string
    {
        $amountWithDecimals = $this->priceInCents / 100;

        return "{$this->currencyCode}:{$amountWithDecimals}";
    }

    public function formattedPrice(): string
    {
        $amount = number_format($this->priceInCents / 100, 2, '.', ' ');

        $amount = Str::replaceLast('.00', '', $amount);

        return "{$amount} {$this->currencyCode}";
    }
}
