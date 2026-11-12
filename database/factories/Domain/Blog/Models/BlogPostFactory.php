<?php

namespace Database\Factories\Domain\Blog\Models;

use App\Domain\Blog\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<BlogPost> */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'markdown' => 'A blog post.',
            'html' => '<p>A blog post.</p>',
            'summary_markdown' => 'A summary.',
            'summary_html' => '<p>A summary.</p>',
            'published' => true,
            'published_at' => now()->subDay(),
            'first_published_at' => now()->subDay(),
            'author_data' => [['name' => 'Freek', 'gravatar_url' => 'https://www.gravatar.com/avatar/'.md5('freek@spatie.be')]],
        ];
    }
}
