<?php

namespace Tests\Factories\Events;

use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Events\ExperienceEarned;

class ExperienceEarnedFactory
{
    private string $email = 'test@spatie.be';

    private int $amount = 10;

    public static function new(): self
    {
        return new self();
    }

    public function create(): ExperienceEarned
    {
        return new ExperienceEarned(
            $this->email,
            null,
            $this->amount,
            ExperienceType::PullRequest(),
        );
    }

    public function withEmail(string $email): self
    {
        $clone = clone $this;

        $clone->email = $email;

        return $clone;
    }

    public function withAmount(int $amount): self
    {
        $clone = clone $this;

        $clone->amount = $amount;

        return $clone;
    }
}
