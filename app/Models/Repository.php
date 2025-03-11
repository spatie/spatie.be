<?php

namespace App\Models;

use App\Actions\SyncRepositoryAdImageToGitHubAdsDiskAction;
use App\Models\Enums\RepositoryType;
use App\Models\Presenters\RepositoryPresenter;
use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Repository extends Model implements HasMedia
{
    use HasFactory;
    use RepositoryPresenter;
    use InteractsWithMedia;

    protected $casts = [
        'new' => 'boolean',
        'topics' => 'array',
        'repository_created_at' => 'datetime',
        'ad_should_be_randomized' => 'boolean',
    ];

    protected $attributes = [
        'ad_should_be_randomized' => true,
    ];

    public static function booted(): void
    {
        self::saved(function (Repository $repository) {
            $repository->load('ad');

            app(SyncRepositoryAdImageToGitHubAdsDiskAction::class)->execute($repository);
        });
    }

    public function scopeAdShouldBeRandomized(Builder $query): void
    {
        $query->where('ad_should_be_randomized', true);
    }

    /** @return BelongsTo<Ad, $this> */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class, 'ad_id');
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

    public function scopeVisible(Builder $builder): void
    {
        $builder->where('visible', true);
    }

    public function scopePackages(Builder $builder): void
    {
        $builder->where('type', RepositoryType::PACKAGE);
    }

    public function scopeProjects(Builder $builder): void
    {
        $builder->where('type', RepositoryType::PROJECT);
    }

    public function scopeHighlighted(Builder $builder): void
    {
        $builder->where('highlighted', true);
    }

    public function scopeSearch(Builder $builder, string $search): void
    {
        if (! $search) {
            return;
        }

        $builder->where('name', 'LIKE', "%{$search}%");
    }

    public function scopeApplySort(Builder $builder, string $sort): void
    {
        if (! $sort) {
            return;
        }

        collect(['name', 'stars', 'repository_created_at', 'downloads'])->first(function (string $validSort) use ($sort) {
            return ltrim($sort, '-') === $validSort;
        }, function () use ($sort) {
            throw new BadMethodCallException('Not allowed to sort by `' . $sort . '`');
        });

        $builder->orderBy(
            ltrim($sort, '-'),
            Str::startsWith($sort, '-') ? 'desc' : 'asc'
        );
    }

    public function hasAdWithImage(): bool
    {
        if (! $ad = $this->ad) {
            return false;
        }

        if (! $ad->image) {
            return false;
        }

        return true;
    }

    public function gitHubAdImagePath(): string
    {
        return Str::slug($this->name) . ".jpg";
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('github-header-light')->singleFile();
        $this->addMediaCollection('github-header-dark')->singleFile();
    }
}
