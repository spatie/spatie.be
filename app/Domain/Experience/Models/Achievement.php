<?php

namespace App\Domain\Experience\Models;

use App\Domain\Experience\Achievements\AchievementResolver;
use App\Domain\Experience\Enums\AchievementType;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\Series;
use App\Models\User;
use Database\Factories\AchievementFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Achievement extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => AchievementType::class,
        'data' => 'array',
    ];

    public static function resolve(object $command): ?self
    {
        $resolver = app(AchievementResolver::class);

        return $resolver->handle($command);
    }

    public function scopeForSeries(Builder $builder, Series $series): void
    {
        $builder->whereJsonContains('data->series_id', $series->id);
    }

    public function scopeForPullRequest(Builder|Achievement $builder): void
    {
        $builder->where('type', AchievementType::PullRequest());
    }

    public function scopeForExperience(Builder|Achievement $builder): void
    {
        $builder->where('type', AchievementType::Experience());
    }

    public function scopeAvailableForUser(Builder|Achievement $builder, User $user): void
    {
        $builder->whereNotIn('id', $user->achievements->pluck('achievement_id'));
    }

    public function receivedBy(int $userId): bool
    {
        return UserAchievementProjection::forUser($userId)
            ->andSlug($this->slug)
            ->exists();
    }

    protected static function newFactory()
    {
        return new AchievementFactory();
    }

    public function getImageUrl(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->image_path);
    }
}
