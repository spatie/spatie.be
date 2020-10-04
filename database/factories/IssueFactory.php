<?php

namespace Database\Factories;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition(): array
    {
        return [
            'repository_id' => function () {
                return Issue::factory()->create()->id;
            },
            'number' => $this->faker->numberBetween(1, 1000),
            'title' => $this->faker->sentence,
            'url' => $this->faker->url,

        ];
    }
}
