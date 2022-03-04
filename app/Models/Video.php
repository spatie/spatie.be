<?php

namespace App\Models;

use App\Actions\UpdateVideoDetailsAction;
use App\Services\Vimeo\Vimeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use League\CommonMark\CommonMarkConverter;

class Video extends Model
{
    use HasFactory;

    protected $casts = [
        'downloadable' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Video $video): void {
            if (! $video->title) {
                $video->title = 'New video';
                $video->runtime = 0;
                $video->hash = '';
            }
        });

        static::saved(fn (Video $video) => app(UpdateVideoDetailsAction::class)->execute($video));
    }

    public function completions(): HasMany
    {
        return $this->hasMany(VideoCompletion::class);
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

        return (new CommonMarkConverter())->convert($this->description);
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

        $currentUser->completeVideo($this);

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
