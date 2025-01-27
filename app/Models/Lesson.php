<?php

namespace App\Models;

use App\Http\Controllers\CoursesController;
use App\Models\Enums\LessonDisplayEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Lesson extends Model implements Sortable
{
    use SortableTrait;
    use HasComments;

    protected $casts = [
        'sort' => 'integer',
        'display_video_icon' => 'boolean',
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

    public static function booted()
    {
        static::updating(function (Lesson $lesson) {
            $lesson->chapter_slug = Str::slug($lesson->chapter);
        });
    }

    /** @return BelongsTo<Series, $this> */
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

    public function getUrlAttribute(): string
    {
        return action([CoursesController::class, 'show'], [$this->series, $this]);
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

        if (app()->environment('local')) {
            return true;
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

    public function hasBeenCompletedByCurrentUser(): bool
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();

        if (! $currentUser) {
            return false;
        }

        return $currentUser->completedLessons()->where('lesson_id', $this->id)->exists();
    }

    public function markAsCompletedForCurrentUser(): self
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();

        if (! $currentUser) {
            return $this;
        }

        if ($this->hasBeenCompletedByCurrentUser()) {
            return $this;
        }

        $currentUser->completeLesson($this);

        return $this;
    }

    public function markAsUncompletedForCurrentUser(): self
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();

        $currentUser->completedLessons()->detach($this);

        return $this;
    }

    public function commentableName(): string
    {
        return $this->title;
    }

    public function commentUrl(): string
    {
        return route('courses.show', [$this->series->slug, $this->slug]);
    }
}
