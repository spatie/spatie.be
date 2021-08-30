<?php

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use App\Models\User;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

    $this->purchasable = Purchasable::factory()->create([
        'price_in_usd_cents' => 10000,
    ]);

    $this->user = User::factory()->create();

    TestTime::freeze();
});

test('a discount without a percentage and name is not active', function () {
    $this->assertFalse($this->purchasable->hasActiveDiscount());

    $this->purchasable->update([
        'discount_percentage' => 30,
        'discount_name' => 'flash sale',
    ]);

    $this->assertTrue($this->purchasable->hasActiveDiscount());
});

test('a discount can be valid during a certain period', function () {
    $this->purchasable->update([
        'discount_percentage' => 30,
        'discount_name' => 'Flash sale',
        'discount_starts_at' => now()->addMinute(),
        'discount_expires_at' => now()->addMinute()->addHour(),
    ]);

    TestTime::addSeconds(59);
    $this->assertFalse($this->purchasable->hasActiveDiscount());

    TestTime::addSecond();
    $this->assertTrue($this->purchasable->hasActiveDiscount());

    TestTime::addHour()->subSecond();
    $this->assertTrue($this->purchasable->hasActiveDiscount());

    TestTime::addSecond();
    $this->assertFalse($this->purchasable->hasActiveDiscount());
});

test('the next purchase discount on a user will be used', function () {
    $this->user->update([
        'next_purchase_discount_period_ends_at' => now()->addHour(),
    ]);

    $this->assertFalse($this->purchasable->hasActiveDiscount());
    $this->assertEquals(10000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);

    $this->actingAs($this->user);
    $this->assertTrue($this->purchasable->hasActiveDiscount());
    $this->assertEquals(9000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);

    TestTime::addHour()->subSecond();
    $this->assertEquals(9000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);
    $this->assertTrue($this->purchasable->hasActiveDiscount());

    TestTime::addSecond();
    $this->assertFalse($this->purchasable->hasActiveDiscount());
    $this->assertEquals(10000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);
});

test('the next purchase discount will be added to a general discount', function () {
    $this->purchasable->update([
        'discount_percentage' => 30,
        'discount_name' => 'Flash sale',
        'discount_starts_at' => now(),
        'discount_expires_at' => now()->addMinute()->addHour(),
    ]);

    $this->user->update([
        'next_purchase_discount_period_ends_at' => now()->addHour(),
    ]);

    $this->assertEquals(7000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);
    $this->actingAs($this->user);
    $this->assertEquals(6000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);
});

it('will add the discount of a referral to all other discount', function () {
    $this->user->update([
        'next_purchase_discount_period_ends_at' => now()->addHour(),
    ]);
    $this->actingAs($this->user);

    /** @var \App\Domain\Shop\Models\Referrer $referrer */
    $referrer = Referrer::factory()->create([
        'discount_percentage' => 10,
    ]);

    $referrer->makeActive();

    $referrer->purchasables()->attach($this->purchasable);

    $this->assertTrue($this->purchasable->hasActiveDiscount());
    $this->assertEquals(8000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);
    $this->assertEquals(20, $this->purchasable->displayableDiscountPercentage());

    $this->purchasable->update([
        'discount_percentage' => 30,
        'discount_name' => 'flash sale',
    ]);

    $this->assertEquals(5000, $this->purchasable->getPriceForCountryCode('BE')->priceInCents);
    $this->assertEquals(50, $this->purchasable->displayableDiscountPercentage());
});

it('will apply discounts to bundles', function () {
    $this->user->update([
        'next_purchase_discount_period_ends_at' => now()->addHour(),
    ]);
    $this->actingAs($this->user);

    /** @var \App\Domain\Shop\Models\Referrer $referrer */
    $referrer = Referrer::factory()->create([
        'discount_percentage' => 10,
    ]);

    $referrer->makeActive();

    /** @var \App\Domain\Shop\Models\Bundle $bundle */
    $bundle = Bundle::factory()->create([
        'price_in_usd_cents' => 10000,
    ]);

    $referrer->bundles()->attach($bundle);

    $this->assertTrue($bundle->hasActiveDiscount());
    $this->assertEquals(8000, $bundle->getPriceForCountryCode('BE')->priceInCents);
    $this->assertEquals(20, $bundle->displayableDiscountPercentage());
});
