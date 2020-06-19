<?php

use App\Models\Insight;
use App\Models\License;
use App\Models\Product;
use App\Models\Purchasable;
use App\Models\User;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Purchase::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(User::class),
        'purchasable_id' => factory(Purchasable::class),
        'license_id' => $faker->boolean ? factory(License::class) : null,
        'payment_method' => $faker->creditCardType,
        'receipt_url' => $faker->url,
        'paddle_webhook_payload' => [],
        'paddle_fee' => random_int(0, 5) * 100,
        'payment_tax' => random_int(1, 5) * 100,
        'earnings' => random_int(100, 1000) * 100,
        'paddle_alert_id' => $faker->randomNumber(5),
    ];
});
