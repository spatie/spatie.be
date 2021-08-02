<?php

namespace Database\Factories;

use App\Models\Bundle;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Paddle\Receipt;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'purchasable_id' => Purchasable::factory(),
            'receipt_id' => function () {
                return Receipt::make()->id;
            },
            'paddle_webhook_payload' => [],
            'paddle_fee' => $this->faker->randomNumber(),
            'earnings' => $this->faker->randomNumber(),
        ];
    }

    public function forBundle()
    {
        return $this->state(function (array $attributes) {
            return [
                'purchasable_id' => null,
                'bundle_id' => Bundle::factory()->has(Purchasable::factory()->count(2)),
            ];
        });
    }
}
