<?php

namespace App\Domain\Shop\Traits;

use App\Domain\Shop\Models\Referrer;
use App\Support\DisplayablePrice;
use App\Support\FreeGeoIp\FreeGeoIp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasPrices
{
    abstract public function prices(): Relation;

    public function getPriceForCurrentRequest(): DisplayablePrice
    {
        return $this->getPriceForIp(request()->ip());
    }

    public function getPriceForIp(string $ip): DisplayablePrice
    {
        $countryCode = FreeGeoIp::getCountryCodeForIp($ip);

        return $this->getPriceForCountryCode($countryCode);
    }

    public function getPriceForCountryCode(string $countryCode): DisplayablePrice
    {
        $displayablePrice = $this->getPriceWithoutDiscountForCountryCode($countryCode);
        if ($this->hasActiveDiscount()) {
            $priceWithoutDiscount = $displayablePrice->priceInCents;

            $discountPercentage = $this->discount_percentage;

            if ($user = auth()->user()) {
                if ($user->enjoysExtraDiscountOnNextPurchase()) {
                    $discountPercentage += $user->nextPurchaseDiscountPercentage();
                }
            }

            $discountPercentage += Referrer::getActiveReferrerDiscountPercentage($this);

            $discount = ($priceWithoutDiscount / 100) * $discountPercentage;

            $priceInCents = $priceWithoutDiscount - $discount;

            $roundedPriceInCents = round($priceInCents / 100) * 100;

            $displayablePrice->priceInCents = $roundedPriceInCents;
        }

        return $displayablePrice;
    }

    public function getPriceWithoutDiscountForCurrentRequest(): DisplayablePrice
    {
        return $this->getPriceWithoutDiscountForIp(request()->ip());
    }

    public function getPriceWithoutDiscountForIp(string $ip): DisplayablePrice
    {
        $countryCode = FreeGeoIp::getCountryCodeForIp($ip);

        return $this->getPriceWithoutDiscountForCountryCode($countryCode);
    }

    public function getPriceWithoutDiscountForCountryCode(string $countryCode): DisplayablePrice
    {
        $price = $this->price_in_usd_cents;
        $currencyCode = 'USD';
        $currencySymbol = '$';

        $purchasablePrice = $this->prices()->firstWhere('country_code', $countryCode);

        if ($purchasablePrice) {
            $price = $purchasablePrice->amount;
            $currencyCode = $purchasablePrice->currency_code;
            $currencySymbol = $purchasablePrice->currency_symbol;
        }

        return new DisplayablePrice($price, $currencyCode, $currencySymbol);
    }

    public function hasActiveDiscount(): bool
    {
        if (optional(auth()->user())->enjoysExtraDiscountOnNextPurchase()) {
            return true;
        }

        if ($referrer = Referrer::findActive()) {
            if ($referrer->hasActiveDiscount($this)) {
                return true;
            }
        }

        if (! $this->discount_name) {
            return false;
        }

        if (! $this->discount_percentage) {
            return false;
        }

        return now()->between(
            $this->discount_starts_at ?? now()->subMinute(),
            $this->discount_expires_at ?? now()->addMinute(),
        );
    }

    public function currentDiscountPercentageExpiresAt(): Carbon
    {
        $userDiscountExpiresAt = now()->subSecond();

        if ($user = current_user()) {
            if ($user->next_purchase_discount_period_ends_at) {
                $userDiscountExpiresAt = $user->next_purchase_discount_period_ends_at;
            }
        }

        $purchasableDiscountExpiresAt = $this->discount_expires_at ?? now()->subSecond();

        return $userDiscountExpiresAt->isAfter($purchasableDiscountExpiresAt)
            ? $userDiscountExpiresAt
            : $purchasableDiscountExpiresAt;
    }

    public function displayableDiscountPercentage(): int
    {
        $percentage = 0;

        $purchasableDiscountExpiresAt = $this->discount_expires_at ?? now()->addSecond();

        if ($purchasableDiscountExpiresAt->isFuture()) {
            $percentage += $this->discount_percentage ?? 0;
        }

        $percentage += Referrer::getActiveReferrerDiscountPercentage($this);

        $user = current_user();

        if (! $user) {
            return $percentage;
        }

        if (! $user->enjoysExtraDiscountOnNextPurchase()) {
            return $percentage;
        }

        return $percentage + $user->nextPurchaseDiscountPercentage();
    }
}
