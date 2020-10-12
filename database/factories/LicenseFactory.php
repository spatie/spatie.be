<?php

namespace Database\Factories;

use App\Models\License;
use App\Models\Purchasable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LicenseFactory extends Factory
{
    protected $model = License::class;

    public function definition(): array
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
