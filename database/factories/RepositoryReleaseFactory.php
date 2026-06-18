<?php

namespace Database\Factories;

use App\Models\Repository;
use App\Models\RepositoryRelease;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<RepositoryRelease> */
class RepositoryReleaseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'repository_id' => Repository::factory(),
            'tag_name' => $this->faker->numerify('#.#.#'),
            'name' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
            'commit_sha' => $this->faker->sha1(),
            'is_release' => true,
            'is_prerelease' => false,
            'released_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
