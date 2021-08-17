<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
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
