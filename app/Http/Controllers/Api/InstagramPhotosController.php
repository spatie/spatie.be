<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstagramPhoto;

class InstagramPhotosController extends Controller
{
    public function __invoke()
    {
        return InstagramPhoto::all()->toJson();
    }
}
