<?php

namespace App\Http\Api\Controllers\Activations;

use App\Domain\Shop\Models\Activation;
use App\Http\Api\Requests\Activations\UpdateCurrentVersionRequest;

class UpdateCurrentVersionController
{
    public function __invoke(Activation $activation, UpdateCurrentVersionRequest $request)
    {
        $activation->update([
           'current_version' => $request->current_version,
            'arch' => $request->arch,
            'platform' => $request->platform,
            'os_version' => $request->os_version,
            'theme' => $request->theme,
        ]);

        return response()->noContent();
    }
}
