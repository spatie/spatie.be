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
    expect($this->purchasable->hasActiveDiscount())->toBeFalse();

    $this->purchasable->update([
        'discount_percentage' => 30,
        'discount_name' => 'flash sale',
    ]);

    expect($this->purchasable->hasActiveDiscount())->toBeTrue();
});

test('a discount can be valid during a certain period', function () {
    $this->purchasable->update([
        'discount_percentage' => 30,
        'discount_name' => 'Flash sale',
        'discount_starts_at' => now()->addMinute(),
        'discount_expires_at' => now()->addMinute()->addHour(),
    ]);

    TestTime::addSeconds(59);
    expect($this->purchasable->hasActiveDiscount())->toBeFalse();

    TestTime::addSecond();
    expect($this->purchasable->hasActiveDiscount())->toBeTrue();

    TestTime::addHour()->subSecond();
    expect($this->purchasable->hasActiveDiscount())->toBeTrue();

    TestTime::addSecond();
    expect($this->purchasable->hasActiveDiscount())->toBeFalse();
});

test('the next purchase discount on a user will be used', function () {
    $this->user->update([
        'next_purchase_discount_period_ends_at' => now()->addHour(),
    ]);

    expect($this->purchasable->hasActiveDiscount())->toBeFalse();
    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(10000);

    $this->actingAs($this->user);
    expect($this->purchasable->hasActiveDiscount())->toBeTrue();
    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(9000);

    TestTime::addHour()->subSecond();
    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(9000);
    expect($this->purchasable->hasActiveDiscount())->toBeTrue();

    TestTime::addSecond();
    expect($this->purchasable->hasActiveDiscount())->toBeFalse();
    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(10000);
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

    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(7000);
    $this->actingAs($this->user);
    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(6000);
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

    expect($this->purchasable->hasActiveDiscount())->toBeTrue();
    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(8000);
    expect($this->purchasable->displayableDiscountPercentage())->toEqual(20);

    $this->purchasable->update([
        'discount_percentage' => 30,
        'discount_name' => 'flash sale',
    ]);

    expect($this->purchasable->getPriceForCountryCode('BE')->priceInCents)->toEqual(5000);
    expect($this->purchasable->displayableDiscountPercentage())->toEqual(50);
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

    expect($bundle->hasActiveDiscount())->toBeTrue();
    expect($bundle->getPriceForCountryCode('BE')->priceInCents)->toEqual(8000);
    expect($bundle->displayableDiscountPercentage())->toEqual(20);
});
