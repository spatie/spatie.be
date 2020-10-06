<?php

namespace App\Models;

use App\Actions\SyncRepositoryAdImageToGitHubAdsDiskAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    use HasFactory;

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $attributes = [
        'active' => true,
    ];

    public static function booted(): void
    {
        self::saved(function (Ad $ad): void {
            if (in_array('image', $ad->getChanges())) {
                $ad->repositories->each(function (Repository $repository) {
                    app(SyncRepositoryAdImageToGitHubAdsDiskAction::class)->execute($repository);
                });
            }
        });

        self::deleting(function (Ad $ad): void {
            $ad->repositories->each(function (Repository $repository) {
                app(DeleteRepositoryAdImageAction::class)->execute($repository);
            });
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class);
    }
}
