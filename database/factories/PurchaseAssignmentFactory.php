<?php

namespace Database\Factories;

use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\PurchaseAssignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseAssignmentFactory extends Factory
{
    protected $model = PurchaseAssignment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'purchasable_id' => Purchasable::factory(),
            'purchase_id' => Purchase::factory(),
            'has_repository_access' => false,
        ];
    }
}
