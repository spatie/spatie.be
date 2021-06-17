<?php

namespace App\Domain\Experience\Events;

use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class VideoCompleted extends ShouldBeStored
{
    public function __construct(
        public UserExperienceId $userExperienceId,
        public int $videoId,
        public int $seriesId,
    ) {
    }
}
