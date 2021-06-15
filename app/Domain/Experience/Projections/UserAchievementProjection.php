<?php

namespace App\Domain\Experience\Projections;

use Spatie\EventSourcing\Projections\Projection;

class UserAchievementProjection extends Projection
{
    protected $table = 'user_achievements';
}
