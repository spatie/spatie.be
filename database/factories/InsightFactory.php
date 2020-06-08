<?php

use App\Models\Insight;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Insight::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'url' => $faker->url,
    ];
});
