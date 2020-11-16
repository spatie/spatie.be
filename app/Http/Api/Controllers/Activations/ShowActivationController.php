<?php

namespace App\Http\Api\Controllers\Activations;

use App\Http\Api\Requests\Activations\ShowActivationRequest;
use App\Models\Activation;

class ShowActivationController
{
    public function __invoke(ShowActivationRequest $request, Activation $activation)
    {
        return response($activation->signed_activation);
    }
}
