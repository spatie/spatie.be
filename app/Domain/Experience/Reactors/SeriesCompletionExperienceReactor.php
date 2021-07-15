<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Events\SeriesCompleted;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class SeriesCompletionExperienceReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus
    )
    {
    }

    public function __invoke(SeriesCompleted $event): void
    {
        $this->bus->dispatch(AddExperience::fromType(
            $event->aggregateRootUuid(),
            $event->userId,
            ExperienceType::SeriesCompletion(),
        ));
    }
}
