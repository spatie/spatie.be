<?php

namespace App\Domain\Experience;

use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Events\ExperienceGainedEvent;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class UserExperience extends AggregateRoot
{
    public function add(
        string $email,
        ?int $userId,
        ExperienceType $type,
    ): self {
        $this->recordThat(new ExperienceGainedEvent(
            email: $email,
            userId: $userId,
            amount: $type->getAmount(),
            type: $type->value,
        ));

        return $this;
    }
}
