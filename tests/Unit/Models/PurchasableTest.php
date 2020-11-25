<?php

namespace Tests\Unit\Models;

use App\Models\Purchasable;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class PurchasableTest extends TestCase
{
    private Purchasable $purchasable;

    public function setUp(): void
    {
        parent::setUp();

        $this->purchasable = Purchasable::factory()->create();
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
        TestTime::freeze();

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
}
