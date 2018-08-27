<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstagramPhotoResource;
use App\Models\InstagramPhoto;

class InstagramPhotosController extends Controller
{
    public function __invoke()
    {
        return InstagramPhotoResource::collection(InstagramPhoto::all());
    }
}
