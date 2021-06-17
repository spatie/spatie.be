<?php

namespace App\Models;

use App\Models\Enums\TechnologyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Technology extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $casts = [
        'type' => TechnologyType::class,
        'recommended_by' => 'array',
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
