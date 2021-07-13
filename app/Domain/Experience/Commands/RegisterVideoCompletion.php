<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Support\Uuid\Uuid;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class RegisterVideoCompletion
{
    public function __construct(
        #[AggregateUuid] public Uuid $uuid,
        public int $userId,
        public int $videoId,
    ) {
    }
}
