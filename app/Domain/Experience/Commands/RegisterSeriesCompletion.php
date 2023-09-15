<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Models\User;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class RegisterSeriesCompletion
{
    public static function forUser(User $user, int $seriesId): self
    {
        return new self(
            uuid: $user->resolveUuid(),
            userId: $user->id,
            seriesId: $seriesId,
        );
    }

    public function __construct(
        #[AggregateUuid]
        public string $uuid,
        public int $userId,
        public int $seriesId,
    ) {
    }
}
