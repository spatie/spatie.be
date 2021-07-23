<?php

namespace App\Domain\Experience\Projections;

use App\Domain\Experience\Enums\ExperienceType;
use Spatie\EventSourcing\Projections\Projection;

class UserExperienceProjection extends Projection
{
    protected $table = 'user_experiences';

    protected $casts = [
        'amount' => 'integer',
        'type' => ExperienceType::class,
    ];
}
