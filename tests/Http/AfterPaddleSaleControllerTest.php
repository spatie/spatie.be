<?php

namespace Tests\Http;

use App\Http\Controllers\AfterPaddleSaleController;
use App\Models\Purchasable;
use Tests\TestCase;

class AfterPaddleSaleControllerTest extends TestCase
{
    /** @test */
    public function the_after_paddle_sale_controller_is_valid()
    {
        /** @var Purchasable $purchasable */
        $purchasable = Purchasable::factory()->create();

        $this
            ->get(action(AfterPaddleSaleController::class, [$purchasable->product->slug, $purchasable]))
            ->assertRedirect(route('products.show', $purchasable->product));
    }
}
