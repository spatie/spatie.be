<?php

namespace Tests\Models;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_the_bundles_where_a_product_is_in()
    {
        $purchasableInBundle = Purchasable::factory()->create();

        /** @var Bundle $bundle */
        $bundle = Bundle::factory()->create();

        $bundle->purchasables()->attach($purchasableInBundle->id);

        $this->assertCount(1, $purchasableInBundle->product->bundles());

        $purchasableNotInBundle = Purchasable::factory()->create();
        $this->assertCount(0, $purchasableNotInBundle->product->bundles());

    }
}
