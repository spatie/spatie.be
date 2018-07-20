<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Insight extends Model
{
    public static function getLatest(): Collection
    {
        return static::query()
            ->latest()
            ->groupBy('website')
            ->get();
    }
}
