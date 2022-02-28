<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $title = "{$this->faker->jobTitle()} as a service";

        return [
            'title' => $title,
            'description' => $this->faker->text(),
            'url' => $this->faker->url(),
            'action_url' => $this->faker->url(),
            'action_label' => $this->faker->sentence(4),
            'slug' => Str::slug($title),
            'private_key' => file_get_contents(__DIR__ . '/../../../stubs/privateKey'),
        ];
    }
}
