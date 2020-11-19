<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class ProductTest extends TestCase
{
    private Product $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
    }

    /** @test */
    public function a_coupon_without_a_code_is_not_active()
    {
        $this->assertFalse($this->product->hasActiveCoupon());

        $this->product->update([
            'coupon_code' => 'test',
            'coupon_percentage' => 30,
        ]);

        $this->assertTrue($this->product->hasActiveCoupon());
    }

    /** @test */
    public function a_coupon_can_be_valid_during_a_certain_period()
    {
        TestTime::freeze();

        $this->product->update([
            'coupon_code' => 'ENJOY-FRONT-LINE-PHP',
            'coupon_percentage' => 30,
            'coupon_valid_from' => now()->addMinute(),
            'coupon_expires_at' => now()->addMinute()->addHour(),
        ]);

        TestTime::addSeconds(59);
        $this->assertFalse($this->product->hasActiveCoupon());

        TestTime::addSecond();
        $this->assertTrue($this->product->hasActiveCoupon());

        TestTime::addHour()->subSecond();
        $this->assertTrue($this->product->hasActiveCoupon());

        TestTime::addSecond();
        $this->assertFalse($this->product->hasActiveCoupon());
    }
}
