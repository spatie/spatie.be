<?php

namespace Tests\Unit\Models;

use App\Models\Purchase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    /** @test */
    public function a_purchase_can_unlock_a_ray_license()
    {
        /** @var \App\Models\Purchase $purchase */
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
