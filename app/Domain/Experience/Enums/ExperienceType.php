<?php

namespace App\Domain\Experience\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PullRequest()
 */
class ExperienceType extends Enum
{
    public function getAmount(): int
    {
        return match($this->value) {
            self::PullRequest()->value => 10,
        };
    }
}
