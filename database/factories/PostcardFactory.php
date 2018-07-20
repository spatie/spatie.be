<?php

use App\Models\Postcard;

$factory->define(Postcard::class, function (Faker\Generator $faker) {
    return [
        'sender' => ($faker->boolean ? '@': '') . $faker->userName . ($faker->boolean ? ', ' . $faker->name : ''),
        'city' => $faker->boolean ? $faker->city : '',
        'country' => $faker->country ? $faker->country : '',
    ];
});
