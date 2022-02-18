<?php

use App\Domain\Shop\Models\Activation;
use App\Domain\Shop\Models\License;
use App\Http\Api\Controllers\Activations\CreateActivationController;
use App\Http\Api\Controllers\Activations\DeleteActivationController;
use App\Http\Api\Controllers\Activations\ShowActivationController;
use Spatie\Crypto\Rsa\PublicKey;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->license = License::factory()->create();

    $this->license->assignment->purchasable->product->update(['maximum_activation_count' => 2]);
});

it('can create an activation', function () {
    $this
        ->postJson(action(CreateActivationController::class, [
            'name' => 'test',
            'license_key' => $this->license->key,
        ]))
        ->assertSuccessful()
        ->assertJsonStructure(['activation_code', 'license_key', 'expires_at', 'signature']);

    expect($this->license->refresh()->activations)->toHaveCount(1);
});

test('the signed activation can be verified', function () {
    $signedData = $this
        ->postJson(action(CreateActivationController::class, [
            'name' => 'test',
            'license_key' => $this->license->key,
        ]))
        ->json();

    $signature = $signedData['signature'];

    unset($signedData['signature']);

    $verified = PublicKey::fromFile(database_path('factories/stubs/publicKey'))
        ->verify(json_encode($signedData), $signature);

    expect($verified)->toBeTrue();
});

it('will not create an activation when the limit has been reached', function () {
    foreach (range(1, $this->license->maximumActivationCount()) as $i) {
        $this
            ->postJson(action(CreateActivationController::class, [
                'name' => 'test',
                'license_key' => $this->license->key,
            ]))
            ->assertSuccessful();
    }
    expect($this->license->refresh()->activations)->toHaveCount($this->license->maximumActivationCount());

    $this
        ->postJson(action(CreateActivationController::class, [
            'name' => 'test',
            'license_key' => $this->license->key,
        ]))
        ->assertJsonValidationErrors('license_key');

    expect($this->license->refresh()->activations)->toHaveCount($this->license->maximumActivationCount());
});

it('can show an activation', function () {
    $this->withExceptionHandling();

    $this
        ->postJson(action(CreateActivationController::class, [
            'name' => 'test',
            'license_key' => $this->license->key,
        ]))
        ->assertSuccessful();

    $activation = Activation::first();

    $this
        ->postJson(action(ShowActivationController::class, $activation), [
            'license_key' => $this->license->key,
        ])
         ->assertSuccessful()
        ->assertJsonStructure(['activation_code', 'license_key', 'expires_at', 'signature']);
});

it('will not show an activation if the license key does not match', function () {
    $this
        ->postJson(action(CreateActivationController::class, [
            'name' => 'test',
            'license_key' => $this->license->key,
        ]))
        ->assertSuccessful();

    $activation = Activation::first();

    $unrelatedLicense = License::factory()->create();

    $this
        ->postJson(action(ShowActivationController::class, $activation), [
            'license_key' => $unrelatedLicense->key,
        ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('will regenerate the signed activation when the license is updated', function () {
    $this
        ->postJson(action(CreateActivationController::class, [
            'name' => 'Franz Thüs',
            'license_key' => $this->license->key,
        ]))
         ->json();

    $newExpiresAt = now();
    $this->license->expires_at = $newExpiresAt;
    $this->license->save();

    $activation = $this->license->refresh()->activations()->first();

    expect($activation->refresh()->signed_activation['expires_at'])->toEqual($newExpiresAt->timestamp);

    $signedData = $activation->signed_activation;
    ksort($signedData);

    $signature = $signedData['signature'];

    unset($signedData['signature']);

    $verified = PublicKey::fromFile(database_path('factories/stubs/publicKey'))
        ->verify(json_encode($signedData), $signature);

    expect($verified)->toBeTrue();
});

it('can delete an activation', function () {
    /** @var Activation $activation */
    $activation = Activation::factory()->create();

    $this
        ->deleteJson(action(DeleteActivationController::class, $activation), [
            'license_key' => $activation->license->key,
        ])
        ->assertSuccessful();

    expect(Activation::count())->toEqual(0);
});
