<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\SignedProductLicenseController;
use App\Models\License;
use App\Models\Product;
use Spatie\Crypto\PublicKey;
use Tests\TestCase;

class SignedLicenseControllerTest extends TestCase
{
    /** @test */
    public function it_can_return_a_signed_license()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $this->withoutExceptionHandling();

        $this
            ->get(action(SignedProductLicenseController::class, [$license->purchasable->product, $license->key]))
            ->assertSuccessful()
            ->assertJsonStructure(['key', 'expires_at', 'signature']);
    }

    /** @test */
    public function it_will_not_return_a_signed_license_for_an_unrelated_product()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $unrelatedProduct = Product::factory()->create();

        $this
            ->get(action(SignedProductLicenseController::class, [$unrelatedProduct, $license->key]))
            ->assertNotFound();
    }

    /** @test */
    public function it_will_not_return_a_signed_license_for_an_invalid_license()
    {
        /** @var License $license */
        $license = License::factory()->create();

        $unrelatedProduct = Product::factory()->create();

        $this
            ->get(action(SignedProductLicenseController::class, [$unrelatedProduct, $license->key . '-invalid']))
            ->assertNotFound();
    }

    /** @test */
    public function it_will_regenerate_the_signed_license_when_the_license_is_updated()
    {
        $license = License::factory()->create();

        $newExpiresAt = now();

        $license->update(['expires_at' => $newExpiresAt]);

        $this->assertEquals($newExpiresAt->timestamp, $license->refresh()->signed_license['expires_at']);

        $signedData = $license->signed_license;
        $signature = $signedData['signature'];

        unset($signedData['signature']);

        $verified = PublicKey::fromFile(database_path('factories/stubs/publicKey'))->verify(json_encode($signedData), $signature);

        $this->assertTrue($verified);
    }
}
