<?php

namespace App\Domain\Experience\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PullRequest()
 * @method static self VideoCompletion()
 * @method static self SeriesCompletion()
 * @method static self ProductSale()
 * @method static self RedeemCode()
 */
class ExperienceType extends Enum
{
    public function getAmount(): int
    {
        return match ($this->value) {
            self::PullRequest()->value => 50,
            self::VideoCompletion()->value => 10,
            self::SeriesCompletion()->value => 20,
            self::ProductSale()->value => 20,
            self::RedeemCode()->value => 10,
        };
    }
}
