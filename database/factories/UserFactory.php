<?php


/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    $name = $faker->firstName;

    return [
        'name' => ucfirst($name),
        'email' => "${name}@spatie.be",
        'password' => bcrypt('password'),
        'is_admin' => false,
    ];
});
