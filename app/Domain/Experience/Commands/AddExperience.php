<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class AddExperience
{
    public static function fromType(
        string $uuid,
        UserExperienceId $userExperienceId,
        ExperienceType $experienceType
    ): self {
        return new self($uuid, $userExperienceId, $experienceType->getAmount());
    }

    public function __construct(
        #[AggregateUuid] public string $uuid,
        private UserExperienceId $userExperienceId,
        private int $amount,
    ) {
    }

    public function getUserExperienceId(): UserExperienceId
    {
        return $this->userExperienceId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
