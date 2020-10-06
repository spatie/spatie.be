<?php

namespace App\Actions;

use App\Models\Purchase;
use App\Models\User;
use App\Services\GitHub\GitHubApi;

class RestoreRepositoryAccessAction
{
    protected GitHubApi $gitHubApi;

    public function __construct(GitHubApi $gitHubApi)
    {
        $this->gitHubApi = $gitHubApi;
    }

    public function execute(User $user): void
    {
        $user->purchases
            ->where('has_repository_access', false)
            ->each(function (Purchase $purchase) use ($user): void {
                info('checking repository access');
                if (! $purchase->purchasable->repository_access) {
                    info('purchasable has no repository access');

                    return;
                }

                if ($purchase->license && $purchase->license->isExpired()) {
                    info('license has expired');

                    return;
                }

                $this->gitHubApi->inviteToRepo(
                    $user->github_username,
                    $purchase->purchasable->repository_access
                );

                $purchase->update(['has_repository_access' => true]);
            });
    }
}
