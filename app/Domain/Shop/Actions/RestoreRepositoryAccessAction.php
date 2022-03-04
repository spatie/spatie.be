<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Exception;

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

            if ($assignment->purchasable->requires_license && ! $hasActiveLicense) {
                return;
            }

            $repositories = explode(',', $assignment->purchasable->repository_access);


            foreach ($repositories as $repository) {
                $repository = trim($repository);

                try {
                    $this->gitHubApi->inviteToRepo(
                        $user->github_username,
                        $repository
                    );
                } catch (Exception $exception) {
                    report("Could not invite GitHub user `{$user->github_username}` to repo `{$repository}`");

                    throw $exception;
                }
            }


            $assignment->update(['has_repository_access' => true]);
        });
    }
}
