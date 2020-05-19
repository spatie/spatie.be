<?php

use App\Models\Repository;

$factory->define(Repository::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'documentation_url' => $faker->boolean ? $faker->url : null,
        'blogpost_url' => $faker->boolean ? $faker->url : null,
        'topics' => $faker->randomElements([$faker->word, $faker->word, $faker->word, $faker->word], $faker->numberBetween(1, 4)),
        'stars' => $faker->numberBetween(0, 5000),
        'downloads' => $faker->numberBetween(0, 1000000),
        'new' => $faker->boolean(20),
        'highlighted' => $faker->boolean(5),
        'language' => $faker->randomElement(['php', 'javascript']),
        'type' => $faker->randomElement(\App\Models\Enums\RepositoryType::toArray()),
    ];
});
