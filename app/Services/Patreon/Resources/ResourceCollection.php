<?php

namespace App\Services\Patreon\Resources;

use Illuminate\Support\Collection;

class ResourceCollection extends Collection
{
    public function add(Resource $resource){
        $this->put($resource->id, $resource);
    }
}