<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Playlist extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $with = [
        'media',
    ];

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl();
    }
}
