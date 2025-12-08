<?php

namespace App\Domain\Shop\Exceptions;

use RuntimeException;

class CouldNotFindCountry extends RuntimeException
{
    public static function fromIp(): self
    {
        return new self();
    }
}
