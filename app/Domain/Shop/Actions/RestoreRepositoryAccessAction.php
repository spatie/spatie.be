<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class RestoreRepositoryAccessAction
{
    protected GitHubApi $gitHubApi;

    public function __construct(GitHubApi $gitHubApi)
    {
        $this->gitHubApi = $gitHubApi;
    }

    public function execute(User $user, bool $refreshExistingAccess = false): void
    {
        $assignments = $user->assignments()
            ->with(['purchasable', 'licenses'])
            ->when(! $refreshExistingAccess, fn (Builder $query) => $query->where('has_repository_access', false))
            ->get();

        $assignments->each(function (PurchaseAssignment $assignment) use ($user) {
            if (! $assignment->isEligibleForRepositoryAccess()) {
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
