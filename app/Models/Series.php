<?php

namespace App\Models;

use App\Models\Enums\VideoDisplayEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Mail\Markdown;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Series extends Model implements HasMedia, Sortable
{
    use InteractsWithMedia, SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function purchasables(): BelongsToMany
    {
        return $this->belongsToMany(Purchasable::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('sort_order');
    }

    public function getUrlAttribute(): string
    {
        return route('series.show', $this);
    }

    public function isPurchasable(): bool
    {
        return $this->purchasables()->count() > 0;
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
        return $this->videos->where('display', VideoDisplayEnum::SPONSORS)->count() > 0;
    }

    public function isOwnedByCurrentUser(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return $this->purchasables
                ->filter(fn (Purchasable $purchasable) => auth()->user()->owns($purchasable))
                ->count() > 0;
    }

    public function getFormattedDescriptionAttribute()
    {
        return Markdown::parse($this->description);
    }
}
