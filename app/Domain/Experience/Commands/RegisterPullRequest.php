<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class RegisterPullRequest
{
    public function __construct(
        #[AggregateUuid] public string $uuid,
        private string $email,
    ) {
    }

    public function getUserExperienceId(): UserExperienceId
    {
        return UserExperienceId::make($this->email);
    }
}
