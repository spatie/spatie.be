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
            ->filter(fn (Purchase $purchase) => $purchase->purchasable->repository_access)
            ->filter(function (Purchase $purchase) {
                if (! $purchase->purchasable->requires_license) {
                    return true;
                }

                foreach ($purchase->licenses as $license) {
                    if (! $license->isExpired()) {
                        return true;
                    }
                }

                return false;
            })
            ->each(function (Purchase $purchase) use ($user) {
                $repositories = explode(', ', $purchase->purchasable->repository_access);

                foreach($repositories as $repository) {
                    $this->gitHubApi->inviteToRepo(
                        $user->github_username,
                        $repository
                    );
                }

                $purchase->update(['has_repository_access' => true]);
            });
    }
}
