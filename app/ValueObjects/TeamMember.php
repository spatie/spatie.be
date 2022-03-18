<?php

namespace App\ValueObjects;

use Carbon\CarbonImmutable;

class TeamMember
{
    private function __construct(
        private string $name,
        private CarbonImmutable $birthday,
        private ?string $nickname,
    ) {
    }

    public static function make(array $data): self
    {
        return new self(
            name: $data['name'],
            birthday: CarbonImmutable::make($data['birthday']),
            nickname: $data['nickname'] ?? null,
        );
    }

    public function name(): string
    {
        return ucfirst($this->nickname ?? $this->name);
    }

    public function isBirthday(): bool
    {
        return $this->birthday->isBirthday();
    }

    public function age(): int
    {
        return $this->birthday->age;
    }
}
