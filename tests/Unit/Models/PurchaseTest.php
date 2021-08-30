<?php

use App\Domain\Shop\Models\Purchase;
use Tests\TestCase;

uses(TestCase::class);

test('a purchase can unlock a ray license', function () {
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
});
