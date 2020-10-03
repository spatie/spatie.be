<?php

namespace Database\Factories;

use App\Actions\SyncRepositoryAdImageToGitHubAdsDisk;
use App\Models\Ad;
use App\Models\Enums\RepositoryType;
use App\Models\Repository;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepositoryFactory extends Factory
{
    protected $model = Repository::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(5, true),
            'description' => $this->faker->sentence,
            'documentation_url' => $this->faker->boolean ? $this->faker->url : null,
            'blogpost_url' => $this->faker->boolean ? $this->faker->url : null,
            'topics' => $this->faker->randomElements([$this->faker->word, $this->faker->word, $this->faker->word, $this->faker->word], $this->faker->numberBetween(1, 4)),
            'stars' => $this->faker->numberBetween(0, 5000),
            'downloads' => $this->faker->numberBetween(0, 1000000),
            'new' => $this->faker->boolean(20),
            'highlighted' => $this->faker->boolean(5),
            'language' => $this->faker->randomElement(['php', 'javascript']),
            'type' => $this->faker->randomElement(RepositoryType::toArray()),
        ];
    }

    public function withAd()
    {
        return $this->state([
            'ad_id' => Ad::factory()->create()->id,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (Repository $repository) {
            $repository->load('ad');

            app(SyncRepositoryAdImageToGitHubAdsDisk::class)->execute($repository);
        });
    }
}
