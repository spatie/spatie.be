<?php

namespace App\Actions\Activations;

use App\Exceptions\MaximumActivationsReached;
use App\Models\Activation;
use App\Models\License;

class CreateActivationAction
{
    public function execute(string $name, License $license): Activation
    {
        if ($license->activations()->count() >= $license->maximumActivationCount()) {
            throw MaximumActivationsReached::make($license);
        }

        $activation = $license->activations()->create(['name' => $name]);

        $activation->updateSignedActivation();

        return $activation;
    }
}
