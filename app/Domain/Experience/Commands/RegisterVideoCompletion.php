<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\Handlers\VideoCompletionHandler;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use App\Support\Uuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(VideoCompletionHandler::class)]
class RegisterVideoCompletion
{
    public function __construct(
        public Uuid $uuid,
        public UserExperienceId $userExperienceId,
        public int $videoId,
        public int $seriesId,
    ) {
    }
}
