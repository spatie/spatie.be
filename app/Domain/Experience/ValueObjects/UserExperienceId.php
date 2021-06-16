<?php

namespace App\Domain\Experience\ValueObjects;

use App\Models\User;

class UserExperienceId
{
    public function __construct(
        public string $email,
        public ?int $userId = null,
    ) {
    }

    public static function make(string $email): self
    {
        return new self(
            email: $email,
            userId: User::query()->where('email', $email)->first()?->id,
        );
    }
}
