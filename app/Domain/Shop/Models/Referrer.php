<?php

namespace App\Domain\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Referrer extends Model
{
    use HasFactory;

    public $guarded = [];

    public $casts = [
        'discount_period_ends_at' => 'datetime',
        'click_count' => 'integer',
        'last_clicked_at' => 'datetime',
    ];

    /** @return BelongsToMany<Purchasable, $this> */
    public function purchasables(): BelongsToMany
    {
        return $this->belongsToMany(Purchasable::class, 'referrer_purchasable');
    }

    /** @return BelongsToMany<Bundle, $this> */
    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(Bundle::class, 'referrer_bundle');
    }

    /** @return BelongsToMany<Purchase, $this> */
    public function usedForPurchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class, 'referrer_purchases');
    }

    public static function activeReferrerGrantsDiscount(Purchasable|Bundle $purchasable): bool
    {
        return static::getActiveReferrerDiscountPercentage($purchasable) > 0;
    }

    public static function booted()
    {
        static::creating(function (Referrer $referrer) {
            $referrer->uuid = (string)Str::uuid();
        });
    }

    public static function getActiveReferrerDiscountPercentage(Purchasable|Bundle $model): int
    {
        if (! $referrer = static::findActive()) {
            return 0;
        }

        return $referrer->getDiscountPercentage($model);
    }

    public function getDiscountPercentage(Purchasable|Bundle $model): int
    {
        if (! $this->purchasables->pluck('id')->contains($model->id) && ! $this->bundles->pluck('id')->contains($model->id)) {
            return 0;
        }

        if (! $this->discount_period_ends_at) {
            return $this->discount_percentage;
        }

        if ($this->discount_period_ends_at->isFuture()) {
            return $this->discount_percentage;
        }

        return 0;
    }

    public function hasActiveDiscount(Purchasable|Bundle $model): bool
    {
        return $this->getDiscountPercentage($model) > 0;
    }

    public static function findActive(): ?self
    {
        if (app()->has('activeReferrer')) {
            return app()->get('activeReferrer');
        }

        $activeReferrerUuid = Cookie::get('active-referrer-uuid');

        if (! $activeReferrerUuid) {
            return null;
        }

        return Referrer::firstWhere(['uuid' => $activeReferrerUuid]);
    }

    public function makeActive(): self
    {
        $cookie = Cookie::make('active-referrer-uuid', $this->uuid);

        app()->bind('activeReferrer', function () {
            return $this;
        });

        Cookie::queue($cookie);

        return $this;
    }

    public function registerClick(): self
    {
        $this->update([
            'click_count' => $this->click_count + 1,
            'last_clicked_at' => now(),
        ]);

        return $this;
    }

    public static function forgetActive(): void
    {
        Cookie::queue(Cookie::forget('active-referrer-uuid'));
    }
}
