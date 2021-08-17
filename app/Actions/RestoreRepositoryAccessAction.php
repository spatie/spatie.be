<?php

namespace App\Actions;

use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\PurchaseAssignment;
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
        $assignments = $user->assignments()
            ->with(['purchasable'])
            ->where('has_repository_access', false)
            ->get();

        $assignments->each(function (PurchaseAssignment $assignment) use ($user) {
            if (! $assignment->purchasable->repository_access) {
                return;
            }

            $hasActiveLicense = $assignment->licenses()
                ->whereNotExpired()
                ->exists();

            if ($assignment->purchasable->requires_license && !$hasActiveLicense) {
                return;
            }

            $repositories = explode(', ', $assignment->purchasable->repository_access);

            foreach($repositories as $repository) {
                $this->gitHubApi->inviteToRepo(
                    $user->github_username,
                    $repository
                );
            }

            $assignment->update(['has_repository_access' => true]);
        });
    }
}
