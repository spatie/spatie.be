<?php

namespace App\Domain\Blog\Models;

use App\Domain\Blog\Data\Author;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogPost extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $casts = [
        'author_data' => 'array',
        'tags' => 'array',
        'published' => 'boolean',
        'published_at' => 'immutable_datetime',
        'first_published_at' => 'immutable_datetime',
    ];

    protected $attributes = [
        'author_data' => '[]',
        'tags' => '[]',
        'published' => false,
        'markdown' => '',
        'html' => '',
    ];

    /** @param Builder<BlogPost> $query */
    public function scopeVisible(Builder $query): void
    {
        $query->where('published', true)->where('published_at', '<=', now());
    }

    public function registerMediaCollections(): void
    {
        foreach (['header', 'og', 'attachments'] as $collection) {
            $this->addMediaCollection($collection)->useDisk('medialibrary');
        }
    }

    public function headerMedia(): ?Media
    {
        return $this->getMedia('header')->sortByDesc('id')->first();
    }

    public function getHeaderImageAttribute(): ?string
    {
        return $this->headerMedia()?->getUrl();
    }

    public function getOgImageAttribute(): ?string
    {
        return $this->getMedia('og')->sortByDesc('id')->first()?->getUrl();
    }

    public function getDateAttribute(): ?CarbonInterface
    {
        return $this->published_at?->utc();
    }

    public function getSummaryAttribute(): string
    {
        return $this->summary_html ?? '';
    }

    public function getContentAttribute(): string
    {
        return $this->html;
    }

    /** @return Collection<int, Author> */
    public function getAuthorsAttribute(): Collection
    {
        return collect($this->author_data)
            ->map(fn (array $author) => new Author($author['name'], $author['gravatar_url'] ?? ''));
    }
}
