<?php

use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Product::class, function (Faker\Generator $faker) {
    $title = "{$faker->jobTitle} as a service";

    return [
        'title' => $title,
        'description' => $faker->text,
        'url' => $faker->url,
        'action_url' => $faker->url,
        'action_label' => $faker->sentence(4),
        'slug' => Str::slug($title),
    ];
});
