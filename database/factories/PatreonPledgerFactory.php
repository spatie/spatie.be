<?php

$factory->define(\App\Models\PatreonPledger::class, function (Faker\Generator $faker) {
    return [
        'patreon_id' => $faker->numberBetween(0, 100000),
        'name' => $faker->name,
        'url_to_original' => $faker->url,
    ];
});
