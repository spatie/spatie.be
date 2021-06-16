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
    public function __construct(
        #[AggregateUuid] public string $uuid,
        private string $email,
        private ExperienceType $type,
    ) {
    }

    public function getUserExperienceId(): UserExperienceId
    {
        return UserExperienceId::make($this->email);
    }

    public function getAmount(): int
    {
        return $this->type->getAmount();
    }

    public function getType(): ExperienceType
    {
        return $this->type;
    }
}
