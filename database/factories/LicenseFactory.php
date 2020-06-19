<?php

use App\Models\Insight;
use App\Models\Product;
use App\Models\Purchasable;
use App\Models\User;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\License::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(User::class),
        'purchasable_id' => factory(Purchasable::class),
        'key' => Str::random(),
        'satis_authentication_count' => random_int(0, 100),
        'expires_at' => $faker->dateTimeBetween('now', '1 year'),
    ];
});
