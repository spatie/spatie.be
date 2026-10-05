<?php

namespace App\Domain\Shop\Exceptions;

use Exception;
use Throwable;

class CouldNotRevokeRepositoryAccess extends Exception
{
    public static function make(string $gitHubUsername, string $repositories, Throwable $previous): self
    {
        return new self(
            "We could not revoke access for `{$gitHubUsername}` to `{$repositories}`. Exception: {$previous->getMessage()}",
            previous: $previous,
        );
    }
}
