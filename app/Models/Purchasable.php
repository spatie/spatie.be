<?php

namespace App\Models;

use App\Support\DisplayablePrice;
use App\Support\FreeGeoIp\FreeGeoIp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Mail\Markdown;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Purchasable extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $casts = [
        'satis_packages' => 'array',
        'released' => 'boolean',
        'discount_percentage' => 'integer',
        'discount_starts_at' => 'datetime',
        'discount_expires_at' => 'datetime',
    ];

    public $with = [
        'media',
    ];

    public static function findForPaddleProductId(string $paddleProductId): ?self
    {
        return static::query()->firstWhere('paddle_product_id', $paddleProductId);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('purchasable-image')
            ->singleFile()
            ->withResponsiveImages();

        $this
            ->addMediaCollection('downloads')
            ->useDisk('purchasable_downloads');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(PurchasablePrice::class);
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('purchasable-image');
    }

    public function renewalPurchasable(): BelongsTo
    {
        return $this->belongsTo(Purchasable::class, 'renewal_purchasable_id');
    }

    public function originalPurchasable()
    {
        return $this->hasOne(Purchasable::class, 'renewal_purchasable_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function series(): BelongsToMany
    {
        return $this->belongsToMany(Series::class);
    }

    public function isRenewal(): bool
    {
        return $this->originalPurchasable()->exists();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('product_id', $this->product_id);
    }

    public function getFormattedDescriptionAttribute()
    {
        return Markdown::parse($this->description);
    }

    public function getAverageEarnings(): int
    {
        $avgEarnings = $this->purchases()->where('earnings', '>', 0)->average('earnings');

        return (int)round($avgEarnings);
    }

    /**
     * @param string $package Package name in following format: `spatie/laravel-mailcoach`
     *
     * @return bool
     */
    public function includesPackageAccess(string $package): bool
    {
        return in_array($package, $this->satis_packages ?? []);
    }

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
        $percentage = $this->discount_percentage ?? 0;

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
