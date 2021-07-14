<?php

namespace App\Domain\Experience\Models;

use App\Domain\Experience\Enums\AchievementType;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\Series;
use Database\Factories\AchievementFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => AchievementType::class,
        'data' => 'array',
    ];

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
}
