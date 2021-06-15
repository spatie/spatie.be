<?php

namespace App\Domain\Experience;

use App\Domain\Experience\Commands\AddUserExperience;
use App\Domain\Experience\Events\ExperienceGainedEvent;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class UserExperience extends AggregateRoot
{
    public function add(AddUserExperience $command): self
    {
        $this->recordThat(new ExperienceGainedEvent(
            email: $command->getEmail(),
            userId: $command->getUserId(),
            amount: $command->getAmount(),
            type: $command->getTypeName(),
        ));

        return $this;
    }
}
