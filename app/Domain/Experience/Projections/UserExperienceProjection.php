<?php

namespace App\Domain\Experience\Projections;

use App\Domain\Experience\Enums\ExperienceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

class UserExperienceProjection extends Projection
{
    protected $table = 'user_experiences';

    protected $casts = [
        'type' => ExperienceType::class,
        'amount' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
