<?php

namespace App\Domain\Shop\Models;

use App\Domain\Shop\Traits\HasPrices;
use App\Http\Controllers\BundlesController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Mail\Markdown;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Bundle extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use SortableTrait;
    use HasPrices;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $casts = [
        'visible' => 'boolean',
        'price_in_usd_cents' => 'integer',
    ];

    public $with = [
        'media',
        'purchasables',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(BundlePrice::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile()
            ->withResponsiveImages();
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }

    public function getAverageEarnings(): int
    {
        $avgEarnings = $this->purchases()->where('earnings', '>', 0)->average('earnings');

        return (int)round($avgEarnings);
    }

    public function purchasables(): BelongsToMany
    {
        return $this->belongsToMany(Purchasable::class)->orderBy('sort_order');
    }

    public function formattedProductNames(): string
    {
        return collect($this->purchasables)
            ->map(fn(Purchasable $purchasable) => $purchasable->product->title)
            ->join(', ', ' and ');
    }

    public function getUrl(): string
    {
        return action([BundlesController::class, 'show'], $this);
    }

    public function getFormattedDescriptionAttribute()
    {
        return Markdown::parse($this->description ?? '');
    }

    public function getFormattedLongDescriptionAttribute()
    {
        return Markdown::parse($this->long_description ?? '');
    }

    public function getFullTitle(): string
    {
        return $this->title;
    }
}
