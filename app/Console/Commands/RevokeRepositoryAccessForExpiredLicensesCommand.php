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
            ->whereHas('license', fn (Builder $query) => $query->whereExpired())
            ->where('has_repository_access', true)
            ->cursor()
            ->each(
                fn (Purchase $purchase) => $gitHubApi->revokeAccessToRepo(
                    $purchase->user->github_username,
                    $purchase->purchasable->repository_access
                )
            );

        $this->info('All done!');
    }
}
