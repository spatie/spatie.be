<?php

namespace App\Domain\Experience\Projections;

use App\Domain\Experience\ValueObjects\UserExperienceId;
use Illuminate\Database\Eloquent\Builder;
use Spatie\EventSourcing\Projections\Projection;

class UserAchievementProjection extends Projection
{
    protected $table = 'user_achievements';

    public function scopeForUser(Builder $builder, UserExperienceId $id): void
    {
        if ($id->userId) {
            $builder->where('user_id', $id->userId);
        } else {
            $builder->where('email', $id->email);
        }
    }

    public function scopeAndSlug(Builder $builder, string $slug): void
    {
        $builder->where('slug', $slug);
    }
}
