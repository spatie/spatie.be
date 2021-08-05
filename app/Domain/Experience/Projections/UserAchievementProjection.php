<?php

namespace App\Domain\Experience\Projections;

use App\Domain\Experience\Models\Achievement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\EventSourcing\Projections\Projection;

class UserAchievementProjection extends Projection
{
    protected $table = 'user_achievements';

    public function scopeForUser(Builder $builder, int $userId): void
    {
        $builder->where('user_id', $userId);
    }

    public function scopeAndSlug(Builder $builder, string $slug): void
    {
        $builder->where('slug', $slug);
    }

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }

    public function getImageUrl(): ?string
    {
        $imagePath = $this->achievement->image_path;

        if (! $imagePath) {
            return null;
        }

        return Storage::disk('public')->url($imagePath);
    }

    public function getAttachmentUrl(): ?string
    {
        $attachmentPath = $this->achievement->attachment_path;

        if (! $attachmentPath) {
            return null;
        }

        return Storage::disk('public')->url($attachmentPath);
    }
}
