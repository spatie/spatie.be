<?php

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use Spatie\TestTime\TestTime;
use Tests\TestCase;



beforeEach(function () {

    TestTime::freeze();

    $this->purchasable = Purchasable::factory()->create();

    $this->referrer = Referrer::factory()->create([
        'discount_period_ends_at' => now()->addHour(),
        'discount_percentage' => 10,
    ]);

    $this->referrer->purchasables()->attach($this->purchasable);
});

it('will allow a discount for a certain purchasable', function () {
    expect($this->referrer->hasActiveDiscount($this->purchasable))->toBeTrue();
    expect($this->referrer->getDiscountPercentage($this->purchasable))->toEqual(10);

    $unrelatedPurchasable = Purchasable::factory()->create();

    expect($this->referrer->hasActiveDiscount($unrelatedPurchasable))->toBeFalse();
    expect($this->referrer->getDiscountPercentage($unrelatedPurchasable))->toEqual(0);
});

it('will allow a discount until the period ends', function () {
    TestTime::addMinutes(59);

    expect($this->referrer->hasActiveDiscount($this->purchasable))->toBeTrue();
    expect($this->referrer->getDiscountPercentage($this->purchasable))->toEqual(10);

    TestTime::addMinute();

    expect($this->referrer->hasActiveDiscount($this->purchasable))->toBeFalse();
    expect($this->referrer->getDiscountPercentage($this->purchasable))->toEqual(0);
});
