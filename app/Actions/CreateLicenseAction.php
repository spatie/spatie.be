<?php

namespace App\Actions;

use App\Models\License;
use App\Models\Product;
use App\Models\User;

class CreateLicenseAction
{
    public function execute(User $user, Product $product): License
    {
        return License::create([
            'key' => Str::random(64),
            'user_id' => $user->id,
            'product_id' => $product->id,
            'expires_at' => now()->addYear(),
        ]);
    }
}
