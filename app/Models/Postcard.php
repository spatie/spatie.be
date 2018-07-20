<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Postcard extends Model implements HasMedia
{
    use HasMediaTrait;

    public $with = [
        'media',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        return $this
            ->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->nonQueued();
    }

    public function getSenderAttribute(): string
    {
        return collect(explode(',', $this->attributes['sender']))
            ->map(function ($sender) {
                $sender = trim($sender);

                if (substr($sender, 0, 1) === '@') {
                    $sender = "<a href='https://twitter.com/{$sender}'>{$sender}</a>";
                }

                return ucfirst($sender);
            })->implode(', ');
    }

    public function getLocationAttribute(): string
    {
        $location = [];

        if ($this->city) {
            $location[] = $this->city;
        }

        if ($this->country) {
            $location[] = $this->country;
        }

        return implode(', ', $location);
    }

    public static function getTopCountries(): Collection
    {
        return Postcard::query()
            ->select('country', DB::raw('COUNT(country) as postcard_count'))
            ->groupBy('country')
            ->orderByDesc('postcard_count')
            ->take(3)
            ->get()
            ->map(function (Postcard $postcard) {
                return [
                    'name' => $postcard->country,
                    'postcard_count' => $postcard->postcard_count,
                ];
            });
    }
}
