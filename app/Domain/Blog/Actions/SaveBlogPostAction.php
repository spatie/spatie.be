<?php

namespace App\Domain\Blog\Actions;

use App\Domain\Blog\Models\BlogPost;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SaveBlogPostAction
{
    public function execute(BlogPost $post, array $data): BlogPost
    {
        if ($post->first_published_at && isset($data['slug']) && $data['slug'] !== $post->slug) {
            throw ValidationException::withMessages(['slug' => 'Published URLs cannot be changed.']);
        }

        $post->fill($data);

        Validator::make($post->getAttributes(), [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'max:255', Rule::notIn(['all', 'authors']), Rule::unique('blog_posts', 'slug')->ignore($post->id)],
            'markdown' => ['required', 'string'],
            'published_at' => [Rule::requiredIf($post->published), 'nullable', 'date'],
        ])->validate();

        $renderer = app(RenderBlogMarkdownAction::class);
        $post->html = $renderer->execute($post->markdown);
        $post->summary_html = $renderer->execute($post->summary_markdown ?? '');

        if ($post->published && ! $post->first_published_at) {
            $post->first_published_at = CarbonImmutable::now();
        }

        $post->save();
        Cache::forget('home.blogPosts');

        return $post;
    }
}
