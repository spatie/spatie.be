<?php

namespace App\Domain\Experience\Events;

use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PullRequestMerged extends ShouldBeStored
{
    public function __construct(
        public UserExperienceId $userExperienceId,
    ) {
    }
}
