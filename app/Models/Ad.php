<?php

namespace App\Models;

use App\Actions\SyncRepositoryAdImageToGitHubAdsDiskAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

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
                app(SyncRepositoryAdImageToGitHubAdsDiskAction::class)->execute($repository);
            });
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    /** @return array<string, string> */
    public static function availableBannerComponents(): array
    {
        return collect(File::files(resource_path('views/components/banners')))
            ->map(fn (SplFileInfo $file) => Str::before($file->getFilename(), '.blade.php'))
            ->reject(fn (string $component) => $component === 'randomBanner')
            ->sort()
            ->mapWithKeys(fn (string $component) => [$component => $component])
            ->all();
    }

    public function bannerView(): ?string
    {
        if (! $this->active) {
            return null;
        }

        if (! $this->banner_component) {
            return null;
        }

        $view = "components.banners.{$this->banner_component}";

        return view()->exists($view) ? $view : null;
    }

    /** @return HasMany<Repository, $this> */
    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class);
    }
}
