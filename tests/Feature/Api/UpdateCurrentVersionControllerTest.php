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

it('can update version with additional metadata', function () {
    $activation = Activation::factory()->create();

    $this
        ->post(action(UpdateCurrentVersionController::class, $activation->uuid), [
            'current_version' => '2.0.0',
            'arch' => 'arm64',
            'platform' => 'darwin',
            'os_version' => '14.1.0',
            'theme' => 'dark',
        ])
        ->assertSuccessful();

    $activation->refresh();

    expect($activation->current_version)->toEqual('2.0.0')
        ->and($activation->arch)->toEqual('arm64')
        ->and($activation->platform)->toEqual('darwin')
        ->and($activation->os_version)->toEqual('14.1.0')
        ->and($activation->theme)->toEqual('dark');
});
