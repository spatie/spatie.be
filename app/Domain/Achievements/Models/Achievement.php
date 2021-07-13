<?php

namespace App\Domain\Achievements\Models;

use App\Domain\Achievements\States\AchievementType;
use App\Domain\Achievements\States\ExperienceAchievementType;
use App\Domain\Achievements\States\PullRequestAchievementType;
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
        $builder->where('type', PullRequestAchievementType::getMorphClass());
    }

    public function scopeForExperience(Builder|Achievement $builder): void
    {
        $builder->where('type', ExperienceAchievementType::getMorphClass());
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
