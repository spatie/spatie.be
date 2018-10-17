<?php

namespace App\Services\Patreon\Resources;

class User
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $imageUrl;

    public function __construct(int $id, string $name, string $imageUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->imageUrl = $imageUrl;
    }

    public static function import(array $data): User
    {
        return new self(
            $data['id'],
            $data['attributes']['full_name'],
            $data['attributes']['image_url']
        );
    }
}
