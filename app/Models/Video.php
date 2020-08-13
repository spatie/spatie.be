<?php

namespace App\Models;

use App\Actions\UpdateVideoDetailsAction;
use App\Http\Controllers\VideosController;
use App\Models\Enums\VideoDisplayEnum;
use App\Services\Vimeo\Vimeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use League\CommonMark\CommonMarkConverter;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Video extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = [];

    protected $casts = [
        'sort' => 'integer',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function (Video $video) {
            if (! $video->title) {
                $video->title = 'New video';
                $video->slug = 'new-video';
                $video->runtime = 0;
            }
        });

        static::saved(fn (Video $video) => app(UpdateVideoDetailsAction::class)->execute($video));
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function getPrevious(): ?Video
    {
        return Video::where('series_id', $this->series_id)
            ->where('sort_order', '<', $this->sort_order)
            ->orderByDesc('sort_order')
            ->limit(1)
            ->first();
    }

    public function getNext(): ?Video
    {
        return Video::where('series_id', $this->series_id)
            ->where('sort_order', '>', $this->sort_order)
            ->orderBy('sort_order')
            ->limit(1)
            ->first();
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
        return static::query()->where('series_id', $this->series_id);
    }

    public function hasBeenCompletedByCurrentUser(): bool
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();

        return $currentUser->completedVideos()->where('video_id', $this->id)->exists();
    }

    public function markAsCompletedForCurrentUser(): self
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = auth()->user();

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
