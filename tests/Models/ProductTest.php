<?php

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use Tests\TestCase;

uses(TestCase::class);

it('can retrieve the bundles where a product is in', function () {
    $purchasableInBundle = Purchasable::factory()->create();

    /** @var Bundle $bundle */
    $bundle = Bundle::factory()->create();

    $bundle->purchasables()->attach($purchasableInBundle->id);

    $this->assertCount(1, $purchasableInBundle->product->bundles());

    $purchasableNotInBundle = Purchasable::factory()->create();
    $this->assertCount(0, $purchasableNotInBundle->product->bundles());

});
