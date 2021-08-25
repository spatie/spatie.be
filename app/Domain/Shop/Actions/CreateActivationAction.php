<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Exceptions\MaximumActivationsReached;
use App\Domain\Shop\Models\Activation;
use App\Domain\Shop\Models\License;

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
