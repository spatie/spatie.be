<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExternalFeedItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'website' => $this->faker->randomElement([
                'rias.be',
                'mailcoach.app',
                'flareapp.io',
                'sebastiandedeyne.com',
            ]),
            'short_summary' => $this->faker->sentence(),
        ];
    }
}
