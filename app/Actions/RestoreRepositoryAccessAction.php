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

    public function execute(User $user)
    {
        $user->purchases
            ->where('has_repository_access', false)
            ->each(function (Purchase $purchase) use ($user) {
                if (! $purchase->purchasable->repository_access) {
                    return;
                }

                if ($purchase->license && $purchase->license->isExpired()) {
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
