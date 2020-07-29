<?php

namespace App\Models;

use App\Models\Enums\RepositoryType;
use App\Models\Presenters\RepositoryPresenter;
use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Repository extends Model
{
    use RepositoryPresenter;

    protected $casts = [
        'new' => 'boolean',
        'topics' => 'array',
        'repository_created_at' => 'datetime',
    ];

    protected $with = ['issues'];

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function getIssuesUrlAttribute()
    {
        return $this->url . '/issues?q=is%3Aopen+is%3Aissue+label%3A"good+first+issue"';
    }

    public function hasIssues(): bool
    {
        return count($this->issues) > 0;
    }

    public function getSlug(): string
    {
        return Str::slug($this->name);
    }

    public function getUrlAttribute(): string
    {
        return "https://github.com/spatie/{$this->name}";
    }

    public function getFullNameAttribute(): string
    {
        return "spatie/{$this->name}";
    }

    public function getLanguageColorAttribute(): string
    {
        $colors = [
            'PHP' => 'blue',
            'JavaScript' => 'orange',
        ];

        return $colors[$this->language] ?? 'gray';
    }

    public static function getTotalDownloads(): int
    {
        return static::sum('downloads');
    }

    public function setTopics(Collection $topics): self
    {
        $this->topics = $topics->toArray();

        $this->save();

        return $this;
    }

    public function scopeVisible(Builder $builder)
    {
        $builder->where('visible', true);
    }

    public function scopePackages(Builder $builder)
    {
        $builder->where('type', RepositoryType::PACKAGE);
    }

    public function scopeProjects(Builder $builder)
    {
        $builder->where('type', RepositoryType::PROJECT);
    }

    public function scopeHighlighted(Builder $builder)
    {
        $builder->where('highlighted', true);
    }

    public function scopeSearch(Builder $builder, string $search)
    {
        if (! $search) {
            return;
        }

        $builder->where('name', 'LIKE', "%{$search}%");
    }

    public function scopeApplySort(Builder $builder, string $sort)
    {
        if (! $sort) {
            return;
        }

        collect(['name', 'stars', 'repository_created_at'])->first(function (string $validSort) use ($sort) {
            return ltrim($sort, '-') === $validSort;
        }, function () use ($sort) {
            throw new BadMethodCallException('Not allowed to sort by `' . $sort . '`');
        });

        $builder->orderBy(
            ltrim($sort, '-'),
            Str::startsWith($sort, '-') ? 'desc' : 'asc'
        );
    }
}
