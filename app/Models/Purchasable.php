<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Purchasable extends Model implements HasMedia, Sortable
{
    use InteractsWithMedia, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $with = [
        'media',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('purchasable-image')
            ->singleFile()
            ->withResponsiveImages();
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('purchasable-image');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}