<?php

namespace App\Exceptions;

use Exception;
use Spatie\WebhookClient\Models\WebhookCall;

class CouldNotHandlePaymentSucceeded extends Exception
{
    public static function userNotFound(array $payload): self
    {
        $email = $payload['email'] ?? '';

        return new static("Could not process paymentSucceeded because no user exists with email `{$email}`");
    }
}
