<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class ReceiptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Laravel\Paddle\Receipt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
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
        'quantity' => (int) 1,
        'paid_at' => $this->faker->dateTime,
    ];
    }
}
