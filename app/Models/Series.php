<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Series extends Model implements HasMedia, Sortable
{
    use InteractsWithMedia, SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function purchasables(): BelongsToMany
    {
        return $this->belongsToMany(Purchasable::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('sort_order');
    }

    public function getUrlAttribute(): string
    {
        return optional($this->videos->first())->url ?? '';
    }
}
