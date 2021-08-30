<?php

namespace Tests\Feature\Api;

use App\Domain\Shop\Models\BundlePrice;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchasablePrice;
use App\Http\Api\Controllers\BundlePriceController;
use App\Http\Api\Controllers\PriceController;
use Spatie\Snapshots\MatchesSnapshots;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class BundlePriceControllerTest extends TestCase
{
    use MatchesSnapshots;

    private BundlePrice $bundlePrice;

    public function setUp(): void
    {
        parent::setUp();

        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $this->bundlePrice = BundlePrice::factory()->create([
            'country_code' => 'BE',
            'amount' => 789,
        ]);

        $this->bundlePrice->bundle->update(['price_in_usd_cents' => 123]);
    }

    /** @test */
    public function if_there_is_no_country_specific_price_it_will_return_the_general_usd_one()
    {
        $this
            ->get(action(BundlePriceController::class, [$this->bundlePrice->bundle->id, 'NL']))
            ->assertJsonPath('actual.price_in_cents', 123);
    }

    /** @test */
    public function it_will_return_the_country_specific_prices_if_it_is_available()
    {
        $this
            ->get(action(BundlePriceController::class, [$this->bundlePrice->id, 'BE']))
            ->assertJsonPath('actual.price_in_cents', 789);
    }

    /** @test */
    public function it_will_return_a_404_if_the_purchasable_is_not_found()
    {
        $this
            ->get(action(BundlePriceController::class, [123, 'BE']))
            ->assertNotFound();
    }
}
