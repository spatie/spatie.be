<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Insight extends Model implements Feedable
{
    use HasFactory;

    public static function getLatest(): Collection
    {
        return static::query()
            ->latest()
            ->get()
            ->unique('website');
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->url)
            ->title($this->title)
            ->summary($this->short_summary)
            ->updated($this->updated_at)
            ->link($this->url)
            ->author($this->website);
    }

    public static function getFeedItems(): Collection
    {
        return self::latest()->get();
    }
}
