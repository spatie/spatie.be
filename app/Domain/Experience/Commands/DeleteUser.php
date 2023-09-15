<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Models\User;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class DeleteUser
{
    public static function forUser(User $user): self
    {
        return new self(
            $user->uuid,
            $user,
        );
    }

    public function __construct(
        #[AggregateUuid]
        public string $uuid,
        public User $user
    ) {
    }
}
