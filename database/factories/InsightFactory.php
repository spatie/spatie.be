<?php

use App\Models\Insight;

$factory->define(Insight::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'url' => $faker->url,
    ];
});
