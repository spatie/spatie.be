<?php

namespace App\Services\Patreon\Resources;

use Illuminate\Support\Collection;

class Campaign
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var \Illuminate\Support\Collection */
    public $rewards;

    public static function import(array $data): Campaign
    {
        return new self(
            $data['id'],
            $data['attributes']['creation_name']
        );
    }

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->rewards = new Collection();
    }
}
