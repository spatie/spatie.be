<?php

use App\Models\License;
use App\Models\Purchasable;
use App\Models\User;
use Laravel\Paddle\Receipt;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Purchase::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(User::class),
        'purchasable_id' => factory(Purchasable::class),
        'license_id' => $faker->boolean ? factory(License::class) : null,
        'receipt_id' => factory(Receipt::class),
    ];
});
