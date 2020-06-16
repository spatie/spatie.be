<?php

use App\Models\Insight;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    $name = $faker->firstName;

    return [
        'name' => ucfirst($name),
        'email' => "${name}@spatie.be",
        'password' => bcrypt('password'),
        'is_admin' => false,
    ];
});
