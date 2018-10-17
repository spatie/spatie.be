<?php

namespace App\Services\Patreon\Resources;

class Reward
{
    /** @var int */
    public $id;

    /** @var int */
    public $amount;

    /** @var string */
    public $title;

    /** @var int */
    public $usersCount;

    public function __construct(int $id, int $amount, string $title, int $usersCount)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->title = $title;
        $this->usersCount = $usersCount;
    }

    public static function import(array $data)
    {
        return new self(
            $data['id'],
            $data['attributes']['amount_cents'],
            $data['attributes']['title'] ?? '',
            $data['attributes']['patron_count'] ?? 0
        );
    }
}
