<?php

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

    TestTime::freeze();

    $this->purchasable = Purchasable::factory()->create();

    $this->referrer = Referrer::factory()->create([
        'discount_period_ends_at' => now()->addHour(),
        'discount_percentage' => 10,
    ]);

    $this->referrer->purchasables()->attach($this->purchasable);
});

it('will allow a discount for a certain purchasable', function () {
    $this->assertTrue($this->referrer->hasActiveDiscount($this->purchasable));
    $this->assertEquals(10, $this->referrer->getDiscountPercentage($this->purchasable));

    $unrelatedPurchasable = Purchasable::factory()->create();

    $this->assertFalse($this->referrer->hasActiveDiscount($unrelatedPurchasable));
    $this->assertEquals(0, $this->referrer->getDiscountPercentage($unrelatedPurchasable));
});

it('will allow a discount until the period ends', function () {
    TestTime::addMinutes(59);

    $this->assertTrue($this->referrer->hasActiveDiscount($this->purchasable));
    $this->assertEquals(10, $this->referrer->getDiscountPercentage($this->purchasable));

    TestTime::addMinute();

    $this->assertFalse($this->referrer->hasActiveDiscount($this->purchasable));
    $this->assertEquals(0, $this->referrer->getDiscountPercentage($this->purchasable));
});
