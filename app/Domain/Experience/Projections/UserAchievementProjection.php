<?php

namespace App\Domain\Experience\Projections;

use Illuminate\Database\Eloquent\Builder;
use Spatie\EventSourcing\Projections\Projection;

class UserAchievementProjection extends Projection
{
    protected $table = 'user_achievements';

    public function scopeForUser(Builder $builder, int $userId): void
    {
        $builder->where('user_id', $userId);
    }

    public function scopeAndSlug(Builder $builder, string $slug): void
    {
        $builder->where('slug', $slug);
    }
}
