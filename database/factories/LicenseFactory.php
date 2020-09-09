<?php

namespace Database\Factories;

use App\Models\Purchasable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class LicenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\License::class;

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
        'key' => Str::random(),
        'satis_authentication_count' => random_int(0, 100),
        'expires_at' => $this->faker->dateTimeBetween('now', '1 year'),
    ];
    }
}
