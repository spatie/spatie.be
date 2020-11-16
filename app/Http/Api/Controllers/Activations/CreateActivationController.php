<?php

namespace App\Http\Api\Controllers\Activations;

use App\Actions\Activations\CreateActivationAction;
use App\Exceptions\MaximumActivationsReached;
use App\Http\Api\Requests\Activations\CreateActivationRequest;
use Illuminate\Validation\ValidationException;

class CreateActivationController
{
    public function __invoke(CreateActivationRequest $request)
    {
        try {
            $activation = app(CreateActivationAction::class)->execute($request->name, $request->license());
        } catch (MaximumActivationsReached $exception) {
            throw ValidationException::withMessages([
                'license_key' => $exception->getMessage(),
            ]);
        }

        return response($activation->signed_activation);
    }
}
