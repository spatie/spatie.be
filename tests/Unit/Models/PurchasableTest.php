<?php

namespace Tests\Unit\Models;

use App\Models\Bundle;
use App\Models\Purchasable;
use App\Models\Referrer;
use App\Models\User;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class PurchasableTest extends TestCase
{
    private Purchasable $purchasable;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->purchasable = Purchasable::factory()->create([
            'price_in_usd_cents' => 10000,
        ]);

        $this->user = User::factory()->create();

        TestTime::freeze();
    }

    /** @test */
    public function a_discount_without_a_percentage_and_name_is_not_active()
    {
        $this->assertFalse($this->purchasable->hasActiveDiscount());

        $this->purchasable->update([
            'discount_percentage' => 30,
            'discount_name' => 'flash sale',
        ]);

        $this->assertTrue($this->purchasable->hasActiveDiscount());
    }

    /** @test */
    public function a_discount_can_be_valid_during_a_certain_period()
    {
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
    }

    /** @test */
    public function the_next_purchase_discount_on_a_user_will_be_used()
    {
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
    }

    /** @test */
    public function the_next_purchase_discount_will_be_added_to_a_general_discount()
    {
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
    }

    /** @test */
    public function it_will_add_the_discount_of_a_referral_to_all_other_discount()
    {
        $this->user->update([
            'next_purchase_discount_period_ends_at' => now()->addHour(),
        ]);
        $this->actingAs($this->user);

        /** @var \App\Models\Referrer $referrer */
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
    }

    /** @test */
    public function it_will_apply_discounts_to_bundles()
    {
        $this->user->update([
            'next_purchase_discount_period_ends_at' => now()->addHour(),
        ]);
        $this->actingAs($this->user);

        /** @var \App\Models\Referrer $referrer */
        $referrer = Referrer::factory()->create([
            'discount_percentage' => 10,
        ]);

        $referrer->makeActive();

        /** @var \App\Models\Bundle $bundle */
        $bundle = Bundle::factory()->create([
            'price_in_usd_cents' => 10000,
        ]);

        $referrer->bundles()->attach($bundle);

        $this->assertTrue($bundle->hasActiveDiscount());
        $this->assertEquals(8000, $bundle->getPriceForCountryCode('BE')->priceInCents);
        $this->assertEquals(20, $bundle->displayableDiscountPercentage());
    }
}
