<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use App\Services\GitHub\RepositoryAccessStatus;
use Illuminate\Database\Eloquent\Builder;

class GetRepositoryAccessStatusesAction
{
    public function __construct(protected GitHubApi $gitHubApi)
    {
    }

    /** @return array<string, RepositoryAccessStatus> */
    public function execute(User $user): array
    {
        if (! $user->github_username) {
            return [];
        }

        $repositories = $user->assignments()
            ->with(['purchasable', 'licenses'])
            ->whereHas('purchasable', fn (Builder $query) => $query->whereNotNull('repository_access'))
            ->get()
            ->filter(fn (PurchaseAssignment $assignment) => $assignment->isEligibleForRepositoryAccess())
            ->flatMap(fn (PurchaseAssignment $assignment) => explode(',', $assignment->purchasable->repository_access))
            ->map(fn (string $repository) => strtolower(trim($repository)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return $this->gitHubApi->repositoryAccessStatuses($user->github_username, $repositories);
    }
}
