<?php

namespace App\Domain\Experience\Projections;

use App\Domain\Experience\Models\Achievement;
use App\Http\Controllers\PublicProfileController;
use App\Models\User;
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
        return $this->achievement?->getImageUrl();
    }

    public function getAttachmentUrl(): ?string
    {
        return $this->achievement?->getAttachmentUrl();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getShareUrl(): string
    {
        return action([PublicProfileController::class, 'achievement'], [
            'userUuid' => $this->user->uuid,
            'slug' => $this->slug,
        ]);
    }

    public function getOgImagePath(): string
    {
        return "achievements/{$this->user_id}-{$this->achievement_id}.png";
    }

    public function getOgImageUrl(): ?string
    {
        return Storage::disk('public')->url($this->getOgImagePath());
    }
}
