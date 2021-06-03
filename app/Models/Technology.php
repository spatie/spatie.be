<?php

namespace App\Models;

use App\Models\Enums\TechnologyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    public $casts = [
        'type' => TechnologyType::class,
        'recommended_by' => 'array',
    ];
}
