<?php

namespace Database\Factories;

use App\Models\License;
use App\Models\Purchasable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Paddle\Receipt;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id' => User::factory(),
        'purchasable_id' => Purchasable::factory(),
        'license_id' => $this->faker->boolean ? License::factory() : null,
        'receipt_id' => Receipt::factory(),
    ];
    }
}
