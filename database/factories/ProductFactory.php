<?php

use App\Models\Insight;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Product::class, function (Faker\Generator $faker) {
    $title = "{$faker->jobTitle} as a service";

    return [
        'title' => $title,
        'type' => \App\Models\Product::TYPE_UNLIMITED_DOMAINS,
        'description' => $faker->text,
        'url' => $faker->url,
        'action_url' => $faker->url,
        'action_label' => $faker->sentence(4),
        'slug' => Str::slug($title),
        'paddle_product_id' => (string) $faker->randomNumber(5),
        'price' => random_int(10, 1000) * 100,
    ];
});
