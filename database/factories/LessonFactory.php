<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'title' => 'test',
            'slug' => 'test',

        ];
    }

    public function configure(): self
    {
        return $this->afterMaking(function (Lesson $lesson) {
            $lesson->content_type = $lesson->getMorphClass();
            $lesson->content_id = Video::factory()->create()->id;
        });
    }
}
