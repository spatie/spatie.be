<?php

namespace App\Domain\Shop\Exceptions;

use Exception;

class CouldNotHandlePaymentSucceeded extends Exception
{
    public static function userNotFound(array $payload): self
    {
        $email = $payload['email'] ?? '';

        return new static("Could not process paymentSucceeded because no user exists with email `{$email}`");
    }
}
