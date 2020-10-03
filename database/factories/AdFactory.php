<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'image' => $this->faker->word,
            'url' => $this->faker->url,
        ];
    }
}
