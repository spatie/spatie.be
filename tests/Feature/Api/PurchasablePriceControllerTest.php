<?php

namespace Tests\Feature\Api;

use App\Http\Api\Controllers\PurchasablePriceController;
use App\Models\Purchasable;
use App\Models\PurchasablePrice;
use Tests\TestCase;

class PurchasablePriceControllerTest extends TestCase
{
    private Purchasable $purchasable;

    public function setUp(): void
    {
        parent::setUp();

        $this->purchasable = Purchasable::factory()->create();
    }

    /** @test */
    public function if_there_is_no_country_specific_price_it_will_return_the_general_usd_one()
    {
        $this
            ->get(action(PurchasablePriceController::class, [$this->purchasable->id, 'BE']))
            ->assertJson([
                'currency' => 'USD',
                'price' => $this->purchasable->price_in_usd_cents,
            ]);
    }

    /** @test */
    public function it_will_return_the_country_specific_prices_if_it_is_available()
    {
        PurchasablePrice::factory()->create([
            'purchasable_id' => $this->purchasable->id,
            'country_code' => 'BE',
            'currency_code' => 'EUR',
            'amount' => 1234,
        ]);

        $this
            ->get(action(PurchasablePriceController::class, [$this->purchasable->id, 'BE']))
            ->assertJson([
                'currency' => 'EUR',
                'price' => 1234,
            ]);
    }

    /** @test */
    public function it_will_return_a_404_if_the_purchasable_is_not_found()
    {
        $this
            ->get(action(PurchasablePriceController::class, [123, 'BE']))
            ->assertNotFound();
    }
}
