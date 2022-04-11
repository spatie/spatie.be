<?php

namespace App\Models;

use App\Domain\Experience\Observers\SeriesAchievementsObserver;
use App\Domain\Shop\Enums\SeriesType;
use App\Domain\Shop\Models\Purchasable;
use App\Models\Enums\LessonDisplayEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Mail\Markdown;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Series extends Model implements HasMedia, Sortable
{
    use InteractsWithMedia;
    use SortableTrait;
    use HasFactory;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $with = [
        'media',
    ];

    protected $casts = [
        'type' => SeriesType::class,
    ];

    protected static function booted()
    {
        self::observe(SeriesAchievementsObserver::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('series-image')
            ->singleFile()
            ->withResponsiveImages();
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('series-image');
    }

    public function purchasables(): BelongsToMany
    {
        return $this->belongsToMany(Purchasable::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function getUrlAttribute(): string
    {
        return route('series.show', $this);
    }

    public function isPurchasable(): bool
    {
        return $this->purchasables()->count() > 0;
    }

    public function sampleVideoUrl(): ?string
    {
        $video = $this->lessons
            ->filter(
                fn ($video) => in_array($video->display, [
                    LessonDisplayEnum::FREE,
                    LessonDisplayEnum::AUTH,
                ])
            )
            ->first();

        if (! $video) {
            return null;
        }

        return route('courses.show', [$this->slug, $video->slug]);
    }

    public function purchaseLink(): string
    {
        if (! $this->isPurchasable()) {
            return '';
        }

        return route('products.show', $this->purchasables->first()->product);
    }

    public function hasSponsoredContent(): bool
    {
        return $this->lessons->where('display', LessonDisplayEnum::SPONSORS)->count() > 0;
    }

    public function isOwnedByCurrentUser(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        if (app()->environment('local')) {
            return true;
        }

        return $this->purchasables
                ->filter(fn (Purchasable $purchasable) => auth()->user()->owns($purchasable))
                ->count() > 0;
    }

    public function getFormattedDescriptionAttribute()
    {
        return Markdown::parse($this->description);
    }

    public function purchasableWithDiscount(): ?Purchasable
    {
        return $this->purchasables()->get()->first(fn (Purchasable $purchasable) => $purchasable->hasActiveDiscount());
    }

    public function getUrlForChapter(string $chapter): string
    {
        $firstLessonInChapter = $this->lessons()->firstWhere('chapter', $chapter);

        return route('courses.show', [$this, $firstLessonInChapter]);
    }
}
