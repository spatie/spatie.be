<?php

namespace App\Domain\Shop\Exceptions;

class CouldNotFindCountry extends \RuntimeException
{
    public static function fromIp(): self
    {
        return new self();
    }
}
