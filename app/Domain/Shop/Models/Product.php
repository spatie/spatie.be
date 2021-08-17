<?php

namespace App\Domain\Shop\Models;

use App\Domain\Shop\Enums\PurchasableType;
use App\Http\Controllers\ProductsController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Mail\Markdown;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $casts = [
        'visible' => 'boolean',
        'coupon_valid_from' => 'datetime',
        'coupon_expires_at' => 'datetime',
        'price_in_usd_cents' => 'integer',
        'maximum_activation_count' => 'integer',
    ];

    public $with = [
        'media',
        'purchasables',
    ];

    private $purchasables;

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('product-image')
            ->singleFile()
            ->withResponsiveImages();
    }

    public function hasGuarantee(): bool
    {
        return in_array($this->slug, [
            'ray',
            'media-library-pro',
            'laravel-backup-server',
            'mailcoach',
        ]);
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('product-image');
    }

    public function purchasables(): HasMany
    {
        return $this->hasMany(Purchasable::class)->orderBy('sort_order');
    }

    public function releases(): HasMany
    {
        return $this->hasMany(Release::class);
    }

    public function purchasablesWithoutRenewals(): HasMany
    {
        return $this->hasMany(Purchasable::class)
            ->orderBy('sort_order')
            ->whereNotIn('type', [
                PurchasableType::TYPE_STANDARD_RENEWAL,
                PurchasableType::TYPE_UNLIMITED_DOMAINS_RENEWAL,
            ])
            ->unless(optional(auth()->user())->hasAccessToUnreleasedProducts(), function (Builder $query) {
                $query->where('released', true);
            });
    }

    public function requiresLicense(): bool
    {
        return $this->purchasables->contains(fn (Purchasable $purchasable) => $purchasable->requires_license);
    }

    public function getUrl(): string
    {
        return action([ProductsController::class, 'show'], $this);
    }

    public function getFormattedDescriptionAttribute()
    {
        return Markdown::parse($this->description ?? '');
    }

    public function getFormattedLongDescriptionAttribute()
    {
        return Markdown::parse($this->long_description ?? '');
    }

    public function purchasableWithDiscount(): ?Purchasable
    {
        return optional($this->purchasables()->get())->first(fn (Purchasable $purchasable) => $purchasable->hasActiveDiscount());
    }
}
