<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Events\PullRequestMerged;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class PullRequestExperienceReactor extends Reactor
{
    public function __construct(private CommandBus $bus)
    {
    }

    public function __invoke(PullRequestMerged $event): void
    {
        $this->bus->dispatch(AddExperience::fromType(
            $event->aggregateRootUuid(),
            $event->userId,
            ExperienceType::PullRequest(),
        ));
    }
}
