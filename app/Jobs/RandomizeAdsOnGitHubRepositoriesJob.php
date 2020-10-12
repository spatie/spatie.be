<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RandomizeAdsOnGitHubRepositoriesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle()
    {
        $ads = Ad::active()->get();

        Repository::adShouldBeRandomized()->each(function (Repository $repository) use ($ads): void {
            $repository->ad()->associate($ads->random());
            $repository->save();
        });
    }
}
