<?php

use App\Models\InstagramPhoto;

$factory->define(InstagramPhoto::class, function (Faker\Generator $faker) {
    return [
        'instagram_id' => $faker->uuid,
        'description' => $faker->sentence,
        'url_to_original' => $faker->url,
        'taken_at' => now(),

    ];
});
