<?php

namespace App\Services\Mailcoach;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;

class Subscriber
{
    public function __construct(
        public string $uuid,
        public string $email,
        public ?CarbonInterface $subscribedAt,
        public ?CarbonInterface $unSubscribedAt,
    ) {
    }

    public static function fromResponse(array $response)
    {
        return new self(
            uuid: $response['uuid'],
            email: $response['email'],
            subscribedAt: !is_null($response['subscribed_at'])
                ? Date::parse($response['subscribed_at'])
                : null,
            unSubscribedAt: !is_null($response['unsubscribed_at'])
                ? Date::parse($response['unsubscribed_at'])
                : null,
        );
    }
}
