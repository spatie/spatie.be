<?php

namespace App\Services\Mailcoach;

class Subscriber
{
    public function __construct(
        public string $uuid,
        public string $email,
    ) {
    }

    public static function fromResponse(array $response)
    {
        return new self(
            uuid: $response['uuid'],
            email: $response['email']
        );
    }
}
