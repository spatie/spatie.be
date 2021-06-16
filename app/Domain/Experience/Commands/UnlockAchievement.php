<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(ExperienceAggregateRoot::class)]
class UnlockAchievement
{
    public function __construct(
        #[AggregateUuid] public string $uuid,
        private string $email,
        private string $title,
    ) {
    }

    public function getUserExperienceId(): UserExperienceId
    {
        return UserExperienceId::make($this->email);
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
