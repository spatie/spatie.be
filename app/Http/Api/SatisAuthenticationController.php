<?php

namespace App\Http\Api;

use Illuminate\Routing\Controller;

class SatisAuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:license-api');
    }

    public function __invoke()
    {
        return response('valid');
    }
}
