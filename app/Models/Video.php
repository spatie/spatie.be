<?php

namespace App\Models;

use App\Http\Controllers\Videos\ShowVideoController;
use App\Services\Vimeo\Vimeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use League\CommonMark\CommonMarkConverter;

class Video extends Model
{
    protected $guarded = [];

    protected $casts = [
        'sort' => 'integer',
        'only_for_sponsors' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function getPrevious(): ?Video
    {
        return Video::where('series_id', $this->series_id)
            ->where('sort', '<', $this->sort)
            ->orderByDesc('sort')
            ->limit(1)
            ->first();
    }

    public function getNext(): ?Video
    {
        return Video::where('series_id', $this->series_id)
            ->where('sort', '>', $this->sort)
            ->orderBy('sort')
            ->limit(1)
            ->first();
    }

    public function getUrlAttribute(): string
    {
        return action(ShowVideoController::class, [$this->series, $this]);
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
}
