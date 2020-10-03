<?php

namespace App\Models;

use App\Actions\SyncRepositoryAdImageToGitHubAdsDisk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    use HasFactory;

    public $guarded = [];

    public static function booted()
    {
        self::saved(function (Ad $ad) {
            if (in_array('image', $ad->getChanges())) {
                $ad->repositories->each(function (Repository $repository) {
                    app(SyncRepositoryAdImageToGitHubAdsDisk::class)->execute($repository);
                });
            }
        });
    }

    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class);
    }
}
