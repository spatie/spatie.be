<?php

namespace App\Services\Patreon\Resources;

class Reward
{
    /** @var int */
    public $id;

    /** @var int */
    public $amount;

    public function __construct(int $id, int $amount)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    public static function import(array $data): Reward
    {
        return new self(
            $data['id'],
            $data['attributes']['amount_cents']
        );
    }
}
