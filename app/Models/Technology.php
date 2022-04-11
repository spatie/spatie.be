<?php

namespace App\Models;

use App\Models\Enums\TechnologyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Technology extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $casts = [
        'type' => TechnologyType::class.':nullable',
        'recommended_by' => 'array',
    ];

    public $attributes = [
        'recommended_by' => '[]',
    ];

    public $with = [
        'media',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }

    public function getAvatarAttribute(): string
    {
        return $this->getFirstMediaUrl('avatar');
    }
}
