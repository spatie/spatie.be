<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Paddle\Receipt;

class ReceiptFactory extends Factory
{
    protected $model = Receipt::class;

    public function definition(): array
    {
        return [
            'billable_id' => User::factory(),
            'billable_type' => User::class,
            'receipt_url' => $this->faker->url,
            'checkout_id' => $this->faker->randomNumber(5),
            'order_id' => $this->faker->randomNumber(5),
            'amount' => random_int(1, 5) * 100,
            'tax' => random_int(1, 5) * 100,
            'currency' => $this->faker->currencyCode,
            'quantity' => (int)1,
            'paid_at' => $this->faker->dateTime,
        ];
    }
}
