<?php

namespace App\Http\Api\Controllers\Activations;

use App\Domain\Shop\Models\Activation;
use App\Http\Api\Requests\Activations\ShowActivationRequest;

class ShowActivationController
{
    public function __invoke(ShowActivationRequest $request, Activation $activation)
    {
        return response($activation->signed_activation);
    }
}
