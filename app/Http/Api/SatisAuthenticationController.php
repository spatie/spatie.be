<?php

namespace App\Http\Api;

class SatisAuthenticationController
{
    public function __construct()
    {
        $this->middleware('auth:license-api');
    }

    public function __invoke()
    {
        return response('valid', 200);
    }
}
