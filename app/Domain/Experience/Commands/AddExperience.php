<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\ExperienceAggregateRoot;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class AddExperience
{
    public static function fromType(
        string $uuid,
        int $userId,
        ExperienceType $experienceType
    ): self {
        return new self($uuid, $userId, $experienceType->getAmount());
    }

    public function __construct(
        #[AggregateUuid]
        public string $uuid,
        public int $userId,
        public int $amount,
    ) {
    }
}
