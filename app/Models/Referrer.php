<?php

namespace App\Models;

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
        'discount_period_ends_at' => 'datetime'
    ];

    public function purchasables(): BelongsToMany
    {
        return $this->belongsToMany(Purchasable::class, 'referrer_purchasable');
    }

    public function usedForPurchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class, 'referrer_purchases');
    }

    public static function activeReferrerGrantsDiscount(Purchasable $purchasable): bool
    {
        return static::getActiveReferrerDiscountPercentage($purchasable) > 0;
    }

    public static function booted()
    {
        static::creating(function(Referrer $referrer) {
            $referrer->uuid = (string)Str::uuid();
        });
    }

    public static function getActiveReferrerDiscountPercentage(Purchasable $purchasable): int
    {
        if (! $referrer = static::findActive()) {
            return 0;
        }

        return $referrer->getDiscountPercentage($purchasable);
    }

    public function getDiscountPercentage(Purchasable $purchasable): int
    {
        if(! $this->purchasables->pluck('id')->contains($purchasable->id)) {
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

    public function hasActiveDiscount(Purchasable $purchasable): bool
    {
        return $this->getDiscountPercentage($purchasable) > 0;
    }

    public static function findActive(): ?static
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

    public function makeActive(): void
    {
        $cookie = Cookie::make('active-referrer-uuid', $this->uuid);

        app()->bind('activeReferrer', function() {
            return $this;
        });

        Cookie::queue($cookie);
    }

    public static function forgetActive(): void
    {
        Cookie::queue(Cookie::forget('active-referrer-uuid'));
    }
}
