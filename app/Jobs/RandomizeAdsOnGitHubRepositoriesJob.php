<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\ArtisanDispatchable\Jobs\ArtisanDispatchable;

class RandomizeAdsOnGitHubRepositoriesJob implements ShouldQueue, ArtisanDispatchable
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $artisanName = 'randomize-github-ads';

    public function handle(): void
    {
        $ads = Ad::query()->whereIn('id', [4,5,7, 9])->get(); // flare, mailcoach, ray, ml pro

        Repository::adShouldBeRandomized()->each(function (Repository $repository) use ($ads) {
            $ad = $ads->random();

            $repository->ad()->associate($ads->random());

            $repository->save();

            echo "Added ad {$ad->id} to repository: {$repository->full_name}";
        });
    }
}
