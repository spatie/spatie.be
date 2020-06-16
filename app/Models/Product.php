<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia, Sortable
{
    use InteractsWithMedia, SortableTrait;

    public const TYPE_STANDARD = 'standard';
    public const TYPE_STANDARD_RENEWAL = 'standard-renewal';
    public const TYPE_UNLIMITED_DOMAINS = 'unlimited-domains';
    public const TYPE_UNLIMITED_DOMAINS_RENEWAL = 'unlimited-domains-renewal';
    public const TYPE_VIDEOS = 'videos';

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $with = [
        'media',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-image')
            ->singleFile()
            ->withResponsiveImages();
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('product-image');
    }
}
