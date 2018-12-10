<?php

namespace App\Services\Patreon\Resources;

class Pledge
{
    /** @var int */
    public $id;

    /** @var int */
    public $amount;

    /** @var int */
    public $userId;

    /** @var \App\Services\Patreon\Resources\User */
    public $user;

    /** @var int|null */
    public $rewardId;

    public static function import(array $pledge): Pledge
    {
        return new self(
            $pledge['id'],
            $pledge['attributes']['amount_cents'],
            $pledge['relationships']['patron']['data']['id'],
            $pledge['relationships']['reward']['data']['id']
        );
    }

    public function __construct(int $id, int $amount, int $userId, ?int $rewardId)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->userId = $userId;
        $this->rewardId = $rewardId;
    }
}
