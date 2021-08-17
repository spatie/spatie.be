<?php

namespace App\Http\Api\Controllers\Activations;

use App\Domain\Shop\Models\Activation;
use App\Http\Api\Requests\Activations\DeleteActivationRequest;

class DeleteActivationController
{
    public function __invoke(DeleteActivationRequest $request, Activation $activation)
    {
        $activation->delete();

        return response()->noContent();
    }
}
