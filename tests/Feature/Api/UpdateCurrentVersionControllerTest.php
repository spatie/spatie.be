<?php

use App\Domain\Shop\Models\Activation;
use App\Http\Api\Controllers\Activations\UpdateCurrentVersionController;

it('can update the current version', function () {
    $activation = Activation::factory()->create();
    $versionNumber = '1.2.3';

    $this
        ->post(action(UpdateCurrentVersionController::class, $activation->uuid), [
            'current_version' => $versionNumber,
        ])
        ->assertSuccessful();

    expect($activation->refresh()->current_version)->toEqual($versionNumber);
});
