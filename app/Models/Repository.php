<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Enums\RepositoryType;
use App\Models\Presenters\RepositoryPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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

        return $colors[$this->language] ?? 'grey';
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

    public static function getHighlightedPackages(): Collection
    {
        $newRepositories = Repository::visible()
            ->where('type', RepositoryType::PACKAGE)
            ->where('new', true)
            ->get();

        $highlightedRepositories = Repository::visible()
            ->where('type', RepositoryType::PACKAGE)
            ->where('highlighted', true)
            ->whereNotIn('id', $newRepositories->pluck('id')->toArray())
            ->get();

        return $newRepositories->concat($highlightedRepositories);
    }

    public static function getAllPackages(): Collection
    {
        return Repository::visible()
            ->where('type', RepositoryType::PACKAGE)
            ->get();
    }

    public static function getAllProjects(): Collection
    {
        $newRepositories = Repository::visible()
            ->where('type', RepositoryType::PROJECT)
            ->where('new', true)
            ->get();

        $highlightedRepositories = Repository::visible()
            ->where('type', RepositoryType::PROJECT)
            ->whereNotIn('id', $newRepositories->pluck('id')->toArray())
            ->get();

        return $newRepositories->concat($highlightedRepositories);
    }
}
