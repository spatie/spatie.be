<?php

namespace App\Services\Patreon\Resources;

use phpDocumentor\Reflection\Types\Boolean;

class Resource
{
    public function is(Resource $resource) : boolean
    {
        return $this->id === $resource->id;
    }
}
