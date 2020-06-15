<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('sort');
    }

    public function getUrlAttribute(): string
    {
        return optional($this->videos->first())->url;
    }
}
