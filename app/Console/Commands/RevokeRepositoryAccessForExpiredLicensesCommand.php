<?php

namespace App\Console\Commands;

use App\Models\Purchase;
use App\Services\GitHub\GitHubApi;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class RevokeRepositoryAccessForExpiredLicensesCommand extends Command
{
    public $signature = 'revoke-repository-access-for-expired-licenses';

    public function handle(GitHubApi $gitHubApi)
    {
        $this->info('Revoking access to repositories for expired licenses...');

        Purchase::query()
            ->whereHas('license', fn(Builder $query) => $query->whereExpired())
            ->where('has_repository_access', true)
            ->cursor()
            ->each(function (Purchase $purchase) use ($gitHubApi) {
                $gitHubApi->revokeAccessToRepo(
                    $purchase->user->github_username,
                    $purchase->purchasable->repository_access
                );

                $purchase->update(['has_repository_access' => false]);
            });

        $this->info('All done!');
    }
}
