<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Insight extends Model
{
    use HasFactory;

    public static function getLatest(): Collection
    {
        return static::query()
            ->latest()
            ->get()
            ->unique('website');
    }
}
