<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Services\GitHub\GitHubApi;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class RevokeRepositoryAccessForExpiredLicensesCommand extends Command
{
    public $signature = 'revoke-repository-access-for-expired-licenses';

    public function handle(GitHubApi $gitHubApi)
    {
        $this->info('Revoking access to repositories for expired licenses...');

        License::query()
            ->whereHas('purchase', fn (Builder $query) => $query->where('has_repository_access', true))
            ->whereExpired()
            ->cursor()
            ->each(function (License $license) use ($gitHubApi) {
                if ($license->purchase->user->licenses()->whereNotExpired()->where('purchasable_id', $license->purchasable_id)->exists()) {
                    // User has another license for this repo
                    return;
                }

                $gitHubApi->revokeAccessToRepo(
                    $license->purchase->user->github_username,
                    $license->purchase->purchasable->repository_access
                );

                $license->purchase->update(['has_repository_access' => false]);
            });

        $this->info('All done!');
    }
}
