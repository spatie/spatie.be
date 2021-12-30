<?php

namespace App\Models;

use App\Models\Enums\LessonDisplayEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use League\CommonMark\CommonMarkConverter;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Lesson extends Model implements Sortable
{
    use SortableTrait;

    protected $casts = [
        'sort' => 'integer',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $guarded = [];

    public function content(): MorphTo
    {
        return $this->morphTo();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function getPrevious(): ?Lesson
    {
        $orderedLessons = $this->series->lessons->groupBy('chapter')->flatten();

        $currentIndex = $orderedLessons->search(fn (Lesson $video) => $video->is($this));

        if ($currentIndex === 0) {
            return null;
        }

        return $orderedLessons[$currentIndex - 1];
    }

    public function getNext(): ?Lesson
    {
        $orderedLessons = $this->series->lessons->groupBy('chapter')->flatten();

        $currentIndex = $orderedLessons->search(fn (Lesson $video) => $video->is($this));

        if ($currentIndex === $orderedLessons->keys()->last()) {
            return null;
        }

        return $orderedLessons[$currentIndex + 1];
    }

    public function getFormattedDescriptionAttribute(): string
    {
        if (! $this->description) {
            return '';
        }

        return (new CommonMarkConverter())->convertToHtml($this->description);
    }

    public function canBeSeenByCurrentUser(): bool
    {
        if ($this->display === LessonDisplayEnum::FREE) {
            return true;
        }

        if (! auth()->check()) {
            return false;
        }

        if ($this->display === LessonDisplayEnum::AUTH) {
            return true;
        }

        $userOwnsSeries = $this->series->isOwnedByCurrentUser();

        if ($this->display === LessonDisplayEnum::SPONSORS) {
            return auth()->user()->isSponsoring() || $userOwnsSeries;
        }

        if ($this->display === LessonDisplayEnum::LICENSE) {
            return $userOwnsSeries;
        }

        return false;
    }

    public function buildSortQuery()
    {
        return static::query()->where('series_id', $this->series_id)->where('chapter', $this->chapter);
    }
}
