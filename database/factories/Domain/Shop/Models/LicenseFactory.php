<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\PurchaseAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LicenseFactory extends Factory
{
    protected $model = License::class;

    public function definition(): array
    {
        return [
            'purchase_assignment_id' => PurchaseAssignment::factory(),
            'key' => Str::random(),
            'satis_authentication_count' => random_int(0, 100),
            'expires_at' => $this->faker->dateTimeBetween('now', '1 year'),
        ];
    }
}
