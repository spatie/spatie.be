<?php

namespace Tests\Feature\Api;

use App\Http\Api\Controllers\Activations\CreateActivationController;
use App\Http\Api\Controllers\Activations\DeleteActivationController;
use App\Http\Api\Controllers\Activations\ShowActivationController;
use App\Models\Activation;
use App\Models\License;
use Spatie\Crypto\PublicKey;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ActivationControllersTest extends TestCase
{
    /** @test */
    public function it_can_create_an_activation()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $this
            ->postJson(action(CreateActivationController::class, [
                'name' => 'test',
                'license_key' => $license->key,
            ]))
            ->assertSuccessful()
            ->assertJsonStructure(['activation_code', 'license_key', 'expires_at', 'signature']);

        $this->assertCount(1, $license->refresh()->activations);
    }

    /** @test */
    public function the_signed_activation_can_be_verified()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $signedData = $this
            ->postJson(action(CreateActivationController::class, [
                'name' => 'test',
                'license_key' => $license->key,
            ]))
            ->json();

        $signature = $signedData['signature'];

        unset($signedData['signature']);

        $verified = PublicKey::fromFile(database_path('factories/stubs/publicKey'))
            ->verify(json_encode($signedData), $signature);

        $this->assertTrue($verified);
    }

    /** @test */
    public function it_will_not_create_an_activation_when_the_limit_has_been_reached()
    {
        /** @var License $license */
        $license = License::factory()->create();

        foreach (range(1, $license->maximumActivations()) as $i) {
            $this
                ->postJson(action(CreateActivationController::class, [
                    'name' => 'test',
                    'license_key' => $license->key,
                ]))
                ->assertSuccessful();
        }
        $this->assertCount($license->maximumActivations(), $license->refresh()->activations);

        $this
            ->postJson(action(CreateActivationController::class, [
                'name' => 'test',
                'license_key' => $license->key,
            ]))
            ->assertJsonValidationErrors('license_key');

        $this->assertCount($license->maximumActivations(), $license->refresh()->activations);
    }

    /** @test */
    public function it_can_show_an_activation()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $this->withExceptionHandling();

        $this
            ->postJson(action(CreateActivationController::class, [
                'name' => 'test',
                'license_key' => $license->key,
            ]))
            ->assertSuccessful();

        $activation = Activation::first();

        $this
            ->postJson(action(ShowActivationController::class, $activation), [
                'license_key' => $license->key,
            ])
             ->assertSuccessful()
            ->assertJsonStructure(['activation_code', 'license_key', 'expires_at', 'signature']);
    }

    /** @test */
    public function it_will_not_show_an_activation_if_the_license_key_does_not_match()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $this->withExceptionHandling();

        $this
            ->postJson(action(CreateActivationController::class, [
                'name' => 'test',
                'license_key' => $license->key,
            ]))
            ->assertSuccessful();

        $activation = Activation::first();

        $unrelatedLicense = License::factory()->create();

        $this
            ->postJson(action(ShowActivationController::class, $activation), [
                'license_key' => $unrelatedLicense->key,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_will_regenerate_the_signed_activation_when_the_license_is_updated()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $this
            ->postJson(action(CreateActivationController::class, [
                'name' => 'test',
                'license_key' => $license->key,
            ]))
             ->json();

        $newExpiresAt = now();
        $license->expires_at = $newExpiresAt;
        $license->save();

        $activation = $license->refresh()->activations()->first();

        $this->assertEquals($newExpiresAt->timestamp, $activation->refresh()->signed_activation['expires_at']);

        $signedData = $activation->signed_activation;
        ksort($signedData);

        $signature = $signedData['signature'];

        unset($signedData['signature']);

        $verified = PublicKey::fromFile(database_path('factories/stubs/publicKey'))
            ->verify(json_encode($signedData), $signature);

        $this->assertTrue($verified);
    }

    /** @test */
    public function it_can_delete_an_activation()
    {
        /** @var Activation $activation */
        $activation = Activation::factory()->create();

        $this
            ->deleteJson(action(DeleteActivationController::class, $activation), [
                'license_key' => $activation->license->key,
            ])
            ->assertSuccessful();

        $this->assertEquals(0, Activation::count());
    }

    /** @test */
    public function it_will_not_delete_an_activation_if_the_license_key_does_not_match()
    {
        /** @var Activation $activation */
        $activation = Activation::factory()->create();

        $unrelatedLicense = License::factory()->create();

        $this
            ->deleteJson(action(DeleteActivationController::class, $activation), [
                'license_key' => $unrelatedLicense->key,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals(1, Activation::count());
    }
}
