<?php

namespace Tests\Unit\Models;

use App\Domain\Shop\Models\Purchase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    /** @test */
    public function a_purchase_can_unlock_a_ray_license()
    {
        $this->markTestSkipped('unlocksRayLicense is currently disabled.');

        /** @var \App\Domain\Shop\Models\Purchase $purchase */
        $purchase = Purchase::factory()->create();

        $purchase->purchasable->product->update([
            'slug' => 'front-line-php',
        ]);
        $this->assertTrue($purchase->unlocksRayLicense());

        $purchase->purchasable->product->update([
            'slug' => 'ray',
        ]);
        $this->assertFalse($purchase->unlocksRayLicense());
    }
}
