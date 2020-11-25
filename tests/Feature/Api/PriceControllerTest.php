<?php

namespace Tests\Feature\Api;

use App\Http\Api\Controllers\PriceController;
use App\Models\Purchasable;
use App\Models\PurchasablePrice;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

class PriceControllerTest extends TestCase
{
    use MatchesSnapshots;

    private Purchasable $purchasable;

    public function setUp(): void
    {
        parent::setUp();

        $this->purchasable = Purchasable::factory()->create([
            'price_in_usd_cents' => 100,
        ]);
    }

    /** @test */
    public function if_there_is_no_country_specific_price_it_will_return_the_general_usd_one()
    {
        $response = $this
            ->get(action(PriceController::class, [$this->purchasable->id, 'BE']))
            ->json();

        $this->assertMatchesSnapshot($response);
    }

    /** @test */
    public function it_will_return_the_country_specific_prices_if_it_is_available()
    {
        PurchasablePrice::factory()->create([
            'purchasable_id' => $this->purchasable->id,
            'country_code' => 'BE',
            'currency_code' => 'EUR',
            'currency_symbol' => '€',
            'amount' => 1234,
        ]);

        $response = $this
            ->get(action(PriceController::class, [$this->purchasable->id, 'BE']))
            ->json();

        $this->assertMatchesSnapshot($response);
    }

    /** @test */
    public function it_will_return_a_404_if_the_purchasable_is_not_found()
    {
        $this
            ->get(action(PriceController::class, [123, 'BE']))
            ->assertNotFound();
    }
}
