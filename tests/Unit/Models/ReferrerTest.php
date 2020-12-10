<?php

namespace Tests\Unit\Models;

use App\Models\Purchasable;
use App\Models\Referrer;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class ReferrerTest extends TestCase
{
    private Purchasable $purchasable;

    private Referrer $referrer;

    public function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();

        $this->purchasable = Purchasable::factory()->create();

        $this->referrer = Referrer::factory()->create([
            'discount_period_ends_at' => now()->addHour(),
            'discount_percentage' => 10,
        ]);

        $this->referrer->purchasables()->attach($this->purchasable);
    }

    /** @test */
    public function it_will_allow_a_discount_for_a_certain_purchasable()
    {
        $this->assertTrue($this->referrer->hasActiveDiscount($this->purchasable));
        $this->assertEquals(10, $this->referrer->getDiscountPercentage($this->purchasable));

        $unrelatedPurchasable = Purchasable::factory()->create();

        $this->assertFalse($this->referrer->hasActiveDiscount($unrelatedPurchasable));
        $this->assertEquals(0, $this->referrer->getDiscountPercentage($unrelatedPurchasable));
    }

    /** @test */
    public function it_will_allow_a_discount_until_the_period_ends()
    {
        TestTime::addMinutes(59);

        $this->assertTrue($this->referrer->hasActiveDiscount($this->purchasable));
        $this->assertEquals(10, $this->referrer->getDiscountPercentage($this->purchasable));

        TestTime::addMinute();

        $this->assertFalse($this->referrer->hasActiveDiscount($this->purchasable));
        $this->assertEquals(0, $this->referrer->getDiscountPercentage($this->purchasable));
    }
}
