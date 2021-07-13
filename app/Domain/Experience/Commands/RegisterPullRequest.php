<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Models\User;
use App\Support\Uuid\Uuid;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class RegisterPullRequest
{
    public static function forUser(User $user): self
    {
        if (! $user->uuid) {
            $user->uuid = (string) Uuid::new();
            $user->save();
        }

        return new self(
            uuid: $user->uuid,
            userId: $user->id,
        );
    }

    public function __construct(
        #[AggregateUuid] public string $uuid,
        public int $userId,
    ) {
    }
}
