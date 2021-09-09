<?php

namespace Tests\Feature\Api;

use App\Domain\Shop\Models\BundlePrice;
use App\Http\Api\Controllers\BundlePriceController;
use Spatie\TestTime\TestTime;
use function Pest\Laravel\get;

beforeEach(function () {
    TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

    $this->bundlePrice = BundlePrice::factory()->create([
        'country_code' => 'BE',
        'amount' => 789,
    ]);

    $this->bundlePrice->bundle->update(['price_in_usd_cents' => 123]);
});

test('if there is no country specific price it will return the general usd one', function () {
    get(action(BundlePriceController::class, [$this->bundlePrice->bundle->id, 'NL']))
        ->assertJsonPath('actual.price_in_cents', 123);
});

it('will return the country specific prices if it is available', function () {
    $bundlePrice = BundlePrice::factory()->create([
        'country_code' => 'BE',
        'amount' => 789,
    ]);

    get(action(BundlePriceController::class, [$bundlePrice->id, 'BE']))
        ->assertJsonPath('actual.price_in_cents', 789);
});


it('it will return a 404 if the purchasable is not found', function () {
    get(action(BundlePriceController::class, [123, 'BE']))
        ->assertNotFound();
});
