<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Spatie\ResponseCache\Facades\ResponseCache;

abstract class Model extends BaseModel
{
    public $guarded = [];

    public static function boot()
    {
        /*
        static::creating(function () {
            ResponseCache::clear();
        });

        static::updating(function () {
            ResponseCache::clear();
        });

        static::deleting(function () {
            ResponseCache::clear();
        });
        */

        parent::boot();
    }
}
