<?php

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use Tests\TestCase;



it('can retrieve the bundles where a product is in', function () {
    $purchasableInBundle = Purchasable::factory()->create();

    /** @var Bundle $bundle */
    $bundle = Bundle::factory()->create();

    $bundle->purchasables()->attach($purchasableInBundle->id);

    expect($purchasableInBundle->product->bundles())->toHaveCount(1);

    $purchasableNotInBundle = Purchasable::factory()->create();
    expect($purchasableNotInBundle->product->bundles())->toHaveCount(0);

});
