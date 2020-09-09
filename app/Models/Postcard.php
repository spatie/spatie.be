<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Postcard extends Model implements HasMedia
{
    use HasFactory;

    use InteractsWithMedia;

    public $with = [
        'media',
    ];

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl();
    }

    public function getSenderAttribute(): string
    {
        if (! isset($this->attributes['sender'])) {
            return '';
        }

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
