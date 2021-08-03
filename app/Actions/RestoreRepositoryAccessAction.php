<?php

namespace App\Actions;

use App\Models\Purchasable;
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
        $purchases = $user->purchases->where('has_repository_access', false);

        $purchases->each(function (Purchase $purchase) use ($user) {
            $purchase->getPurchasables()->each(function (Purchasable $purchasable) use ($user, $purchase) {
                if (! $purchasable->repository_access) {
                    return;
                }

                $hasActiveLicense = $purchase->licenses()
                    ->where('purchasable_id', $purchasable->id)
                    ->whereNotExpired()
                    ->exists();
                if ($purchasable->requires_license && !$hasActiveLicense) {
                    return;
                }

                $repositories = explode(', ', $purchasable->repository_access);

                foreach($repositories as $repository) {
                    $this->gitHubApi->inviteToRepo(
                        $user->github_username,
                        $repository
                    );
                }

                $purchase->update(['has_repository_access' => true]);
            });
        });
    }
}
