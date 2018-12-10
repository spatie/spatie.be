<?php

namespace App\Services\Patreon\Resources;

class User
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $avatarUrl;

    public static function import(array $data): User
    {
        return new self(
            $data['id'],
            $data['attributes']['full_name'],
            $data['attributes']['image_url']
        );
    }

    public function __construct(int $id, string $name, string $avatarUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->avatarUrl = $avatarUrl;
    }
}
