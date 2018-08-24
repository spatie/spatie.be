<?php

namespace App\Services\Instagram;

use Carbon\Carbon;
use stdClass;

class InstagramPhoto
{
    /** @var \stdClass */
    protected $properties;

    public function __construct(stdClass $properties)
    {
        $this->properties = $properties;
    }

    public function __call($name, $arguments)
    {
        return $this->properties->$name;
    }

    public function imageUrl(): string
    {
        return $this->properties->images->standard_resolution->url;
    }

    public function caption(): string
    {
        return $this->properties->caption->text;
    }

    public function hasTag(string $tagName): bool
    {
        return in_array($tagName, $this->properties->tags ?? []);
    }

    public function createdTime(): Carbon
    {
        return Carbon::createFromTimestamp($this->properties->created_time);
    }
}
