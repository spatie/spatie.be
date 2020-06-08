<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\InstagramPhotoResource;
use App\Models\InstagramPhoto;

class InstagramPhotosController
{
    public function __invoke()
    {
        return InstagramPhotoResource::collection(InstagramPhoto::all());
    }
}
