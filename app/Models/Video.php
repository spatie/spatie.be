<?php

namespace App\Models;

use App\Actions\UpdateVideoDetailsAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use League\CommonMark\CommonMarkConverter;

class Video extends Model
{
    use HasFactory;

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

    /** @return HasMany<LessonCompletion, $this> */
    public function completions(): HasMany
    {
        return $this->hasMany(LessonCompletion::class);
    }

    public function getFormattedDescriptionAttribute(): string
    {
        if (! $this->description) {
            return '';
        }

        return (new CommonMarkConverter())->convert($this->description);
    }

    public function lesson(): MorphOne
    {
        return $this->morphOne(Lesson::class, 'content');
    }
}
