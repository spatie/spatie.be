<?php

use App\Domain\Shop\Models\Purchase;

test('a purchase can unlock a ray license', function () {
    $this->markTestSkipped('unlocksRayLicense is currently disabled.');

    /** @var \App\Domain\Shop\Models\Purchase $purchase */
    $purchase = Purchase::factory()->create();

    $purchase->purchasable->product->update([
        'slug' => 'front-line-php',
    ]);
    expect($purchase->unlocksRayLicense())->toBeTrue();

    $purchase->purchasable->product->update([
        'slug' => 'ray',
    ]);
    expect($purchase->unlocksRayLicense())->toBeFalse();
});
