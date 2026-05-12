<?php

use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Models\User;
use Spatie\TestTime\TestTime;

it('does not show an expired discount name for a personal discount', function () {
    TestTime::freeze();

    $user = User::factory()->create([
        'next_purchase_discount_period_ends_at' => now()->addHour(),
    ]);

    $product = Product::factory()->create();

    Purchasable::factory()->create([
        'product_id' => $product->id,
        'price_in_usd_cents' => 24900,
        'discount_name' => 'BLACK FRIDAY',
        'discount_percentage' => 30,
        'discount_starts_at' => now()->subDays(10),
        'discount_expires_at' => now()->subDay(),
    ]);

    $this
        ->actingAs($user)
        ->get(route('products.show', $product))
        ->assertOk()
        ->assertSeeText('Personal discount included!')
        ->assertSeeTextInOrder(['Now', '10%', 'off', 'for you'])
        ->assertDontSeeText('BLACK FRIDAY');
});
