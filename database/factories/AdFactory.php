<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\File as LocalFile;
use Illuminate\Support\Facades\Storage;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'image' => $this->faker->word,
            'url' => $this->faker->url,
            'active' => $this->faker->boolean(90),
        ];
    }

    public function active(): self
    {
        return $this->state([
            'active' => true,
        ]);
    }

    public function inactive(): self
    {
        return $this->state([
            'active' => false,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (Ad $ad) {
            $imagePath = Storage::disk('github_ads')->putFile('ads', new File($this->randomAdStubPath()));

            $ad->update(['image' => $imagePath]);
        });
    }

    protected function randomAdStubPath(): string
    {
        $directory = __DIR__ . '/../stubs/ads';

        return collect(LocalFile::allFiles($directory))->random();
    }
}
