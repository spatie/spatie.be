<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Commands\RegisterSeriesCompletion;
use App\Domain\Experience\Events\VideoCompleted;
use App\Models\Series;
use App\Models\User;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class SeriesCompletionReactor extends Reactor
{
    public function __construct(
        protected CommandBus $bus
    ) {
    }

    public function __invoke(VideoCompleted $event): void
    {
        /** @var \App\Models\User $user */
        $user = User::find($event->userId);

        /** @var \App\Models\Series $series */
        $series = Series::find($event->seriesId);

        if (! $user->hasCompleted($series)) {
            return;
        }

        $this->bus->dispatch(RegisterSeriesCompletion::forUser(
            $user,
            $event->seriesId,
        ));
    }
}
