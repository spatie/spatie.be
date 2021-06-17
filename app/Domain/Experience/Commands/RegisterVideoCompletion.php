<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use App\Support\Uuid\Uuid;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class RegisterVideoCompletion
{
    public function __construct(
        #[AggregateUuid] public Uuid $uuid,
        public UserExperienceId $userExperienceId,
        public int $videoId,
    ) {
    }
}
