<?php

use App\Models\User;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Laravel\Paddle\Receipt::class, function (Faker\Generator $faker) {
    return [
        'billable_id' => factory(User::class),
        'billable_type' => User::class,
        'receipt_url' => $faker->url,
        'checkout_id' => $faker->randomNumber(5),
        'order_id' => $faker->randomNumber(5),
        'amount' => random_int(1, 5) * 100,
        'tax' => random_int(1, 5) * 100,
        'currency' => $faker->currencyCode,
        'quantity' => (int) 1,
        'paid_at' => $faker->dateTime,
    ];
});
