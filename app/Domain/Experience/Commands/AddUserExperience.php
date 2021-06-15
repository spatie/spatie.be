<?php

namespace App\Domain\Experience\Commands;

use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\UserExperience;
use App\Models\User;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(UserExperience::class)]
class AddUserExperience
{
    public function __construct(
        #[AggregateUuid] public string $uuid,
        private string $email,
        private ExperienceType $type,
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

    public function getTypeName(): string
    {
        return $this->type->value;
    }

    public function getAmount(): int
    {
        return $this->type->getAmount();
    }


}
