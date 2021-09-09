<?php

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchasablePrice;
use App\Http\Api\Controllers\PriceController;
use Spatie\Snapshots\MatchesSnapshots;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

uses(MatchesSnapshots::class);

beforeEach(function () {
    TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

    $this->purchasable = Purchasable::factory()->create([
        'price_in_usd_cents' => 14900,
    ]);
});

test('if there is no country specific price it will return the general usd one', function () {
    $response = $this
        ->get(action(PriceController::class, [$this->purchasable->id, 'BE']))
        ->json();

    $this->assertMatchesSnapshot($response);
});

it('will return the country specific prices if they are available', function () {
    PurchasablePrice::factory()->create([
        'purchasable_id' => $this->purchasable->id,
        'country_code' => 'BE',
        'currency_code' => 'EUR',
        'currency_symbol' => '€',
        'amount' => 13900,
    ]);

    $response = $this
        ->get(action(PriceController::class, [$this->purchasable->id, 'BE']))
        ->json();

    $this->assertMatchesSnapshot($response);
});

it('will return a 404 if the purchasable is not found', function () {
    $this
        ->get(action(PriceController::class, [123, 'BE']))
        ->assertNotFound();
});

it('will return the correct usd prices is there is a discount', function () {
    $this->purchasable->update([
        'discount_percentage' => 10,
        'discount_name' => 'Flash sale',
        'discount_expires_at' => now()->addHour(),
    ]);

    $response = $this
        ->get(action(PriceController::class, [$this->purchasable->id, 'BE']))
        ->json();

    $this->assertMatchesSnapshot($response);
});

it('will return the correct custom prices is there is a discount', function () {
    $this->purchasable->update([
        'discount_percentage' => 10,
        'discount_name' => 'Flash sale',
        'discount_expires_at' => now()->addHour(),
    ]);

    PurchasablePrice::factory()->create([
        'purchasable_id' => $this->purchasable->id,
        'country_code' => 'BE',
        'currency_code' => 'EUR',
        'currency_symbol' => '€',
        'amount' => 13900,
    ]);

    $response = $this
        ->get(action(PriceController::class, [$this->purchasable->id, 'BE']))
        ->json();

    $this->assertMatchesSnapshot($response);
});
