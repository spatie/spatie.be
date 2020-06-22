<?php

use App\Enums\PurchasableType;
use App\Models\Insight;
use App\Models\Product;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Purchasable::class, function (Faker\Generator $faker) {
    $title = "{$faker->jobTitle} as a service";

    return [
        'title' => $title,
        'product_id' => factory(Product::class),
        'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS,
        'description' => $faker->text,
        'paddle_product_id' => (string) $faker->randomNumber(5),
    ];
});
