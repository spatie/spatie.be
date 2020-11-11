<?php

namespace App\Console\Commands;

use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use Illuminate\Console\Command;

class RandomizeAdsOnGitHubRepositoriesCommand extends Command
{
    protected $signature = 'randomize-ads';

    protected $description = 'Randomize ads on GitHub';

    public function handle()
    {
        dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

        $this->info('Job to randomize ads dispatched...');
    }
}
