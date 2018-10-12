<?php

namespace App\Services\Patreon\Resources;

class Campaign extends Resource
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $pledgedSum;

    public function __construct(int $id, string $name, int $pledgedSum)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pledgedSum = $pledgedSum;
    }

    public static function import(array $data)
    {
        return new self(
            $data['id'],
            $data['attributes']['creation_name'],
            $data['attributes']['pledge_sum']
        );
    }
}
