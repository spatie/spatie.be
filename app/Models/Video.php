<?php

namespace App\Models;

use App\Actions\UpdateVideoDetailsAction;
use App\Http\Controllers\VideosController;
use App\Models\Enums\VideoDisplayEnum;
use App\Services\Vimeo\Vimeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use League\CommonMark\CommonMarkConverter;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Video extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $casts = [
        'sort' => 'integer',
        'downloadable' => 'boolean',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Video $video): void {
            if (! $video->title) {
                $video->title = 'New video';
                $video->slug = 'new-video';
                $video->runtime = 0;
            }
        });

        static::saved(fn (Video $video) => app(UpdateVideoDetailsAction::class)->execute($video));
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function completions(): HasMany
    {
        return $this->hasMany(VideoCompletion::class);
    }

    public function getPrevious(): ?Video
    {
        $orderedVideos = $this->series->videos->groupBy('chapter')->flatten();

        $currentIndex = $orderedVideos->search(fn (Video $video) => $video->is($this));

        if ($currentIndex === 0) {
            return null;
        }

        return $orderedVideos[$currentIndex - 1];
    }

    public function getNext(): ?Video
    {
        $orderedVideos = $this->series->videos->groupBy('chapter')->flatten();

        $currentIndex = $orderedVideos->search(fn (Video $video) => $video->is($this));

        if ($currentIndex === $orderedVideos->keys()->last()) {
            return null;
        }

        return $orderedVideos[$currentIndex + 1];
    }

    public function getUrlAttribute(): string
    {
        return action([VideosController::class, 'show'], [$this->series, $this]);
    }

    protected function getDownloadUrls(): Collection
    {
        return Cache::remember('video_'.$this->id, now()->addMinute(), function () {
            $video = app(Vimeo::class)->getVideo($this->vimeo_id);

            return collect(Arr::get($video, 'download'));
        });
    }

    public function getDownloadHdUrlAttribute(): string
    {
        $download = $this->getDownloadUrls()->first(fn ($download) => $download['quality'] === 'hd');

        return $download['link'] ?? '';
    }

    public function getDownloadSdUrlAttribute(): string
    {
        $download = $this->getDownloadUrls()->first(fn ($download) => $download['quality'] === 'sd');

        return $download['link'] ?? '';
    }

    public function getDownloadHdSizeAttribute(): string
    {
        $download = $this->getDownloadUrls()->first(fn ($download) => $download['quality'] === 'hd');

        return $download['size'] ?? '';
    }

    public function getDownloadSdSizeAttribute(): string
    {
        $download = $this->getDownloadUrls()->first(fn ($download) => $download['quality'] === 'sd');

        return $download['size'] ?? '';
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
        if ($this->display === VideoDisplayEnum::FREE) {
            return true;
        }

        if (! auth()->check()) {
            return false;
        }

        if ($this->display === VideoDisplayEnum::AUTH) {
            return true;
        }

        $userOwnsSeries = $this->series->isOwnedByCurrentUser();

        if ($this->display === VideoDisplayEnum::SPONSORS) {
            return auth()->user()->isSponsoring() || $userOwnsSeries;
        }

        if ($this->display === VideoDisplayEnum::LICENSE) {
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

        return $currentUser->completedVideos()->where('video_id', $this->id)->exists();
    }

    public function markAsCompletedForCurrentUser(): self
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();

        if (! $currentUser) {
            return $this;
        }

        $currentUser->completedVideos()->syncWithoutDetaching($this);

        return $this;
    }

    public function markAsUncompletedForCurrentUser(): self
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();

        $currentUser->completedVideos()->detach($this);

        return $this;
    }
}
