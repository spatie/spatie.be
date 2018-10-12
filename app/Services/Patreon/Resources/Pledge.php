<?php

namespace App\Services\Patreon\Resources;

class Pledge extends Resource
{
    /** @var int */
    public $id;

    /** @var int */
    public $amount;

    /** @var int */
    public $userId;

    /** @var \App\Services\Patreon\Resources\User */
    public $user;

    public function __construct(int $id, int $amount, int $userId)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->userId = $userId;
    }

    public function setuser(User $user){
        $this->user = $user;
    }

    public static function import(array $pledge): Pledge
    {
        return new self(
            $pledge['id'],
            $pledge['attributes']['amount_cents'],
            $pledge['relationships']['patron']['data']['id']
        );
    }
}