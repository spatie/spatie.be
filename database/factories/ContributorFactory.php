<?php

use App\Models\Contributor;

$factory->define(Contributor::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'avatar_url' => $faker->imageUrl(),
        'repository_url' => $faker->url,
        'repository_name' => $faker->word,
    ];
});
