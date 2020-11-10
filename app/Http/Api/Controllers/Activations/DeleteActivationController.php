<?php

namespace App\Http\Api\Controllers\Activations;

use App\Http\Api\Requests\Activations\DeleteActivationRequest;
use App\Models\Activation;

class DeleteActivationController
{
    public function __invoke(DeleteActivationRequest $request, Activation $activation)
    {
        $activation->delete();

        return response()->noContent();
    }
}
