<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\ExperienceAggregateRoot;
use App\Models\User;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserId(): ?int
    {
        return User::query()->where('email', $this->email)->first()?->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
