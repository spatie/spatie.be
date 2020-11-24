<?php

namespace App\Models;

use App\Support\FreeGeoIp\FreeGeoIp;
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

    public function getPriceForIp(string $ip): array
    {
        $countryCode = FreeGeoIp::getCountryCodeForIp($ip);
        $countryCode = 'TH';
        $price = $this->prices()->firstWhere('country_code', $countryCode);

        if ($price) {
            return [$price->amount, $price->currency_code];
        }

        return [$this->product->price, 'USD'];
    }
}
