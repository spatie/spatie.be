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
            ->filter(fn(Purchase $purchase) => $purchase->purchasable->repository_access)
            ->reject(fn(Purchase $purchase) => $purchase->license && $purchase->license->isExpired())
            ->each(function (Purchase $purchase) use ($user) {
                $this->gitHubApi->inviteToRepo(
                    $user->github_username,
                    $purchase->purchasable->repository_access
                );

                $purchase->update(['has_repository_access' => true]);
            });
    }
}
