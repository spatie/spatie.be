<?php

$factory->define(\App\Models\PatreonPledger::class, function (Faker\Generator $faker) {
    return [
        'patreon_id' => $faker->numberBetween(0, 100000),
        'name' => $faker->name,
        'avatar_url' => $faker->url,
    ];
});
