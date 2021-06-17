<?php

namespace App\Domain\Achievements\Models;

use App\Domain\Achievements\States\AchievementType;
use App\Models\Series;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $casts = [
        'type' => AchievementType::class,
        'data' => 'array',
    ];

    public function scopeForSeries(Builder $builder, Series $series): void
    {
        $builder->whereJsonContains('data->series_id', $series->id);
    }
}
