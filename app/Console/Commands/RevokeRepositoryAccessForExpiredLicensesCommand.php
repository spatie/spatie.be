<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class RevokeRepositoryAccessForExpiredLicensesCommand extends Command
{
    public $signature = 'revoke-repository-access-for-expired-licenses';

    public function __construct(private Log $log)
    {
        parent::__construct();
    }

    public function handle(GitHubApi $gitHubApi): void
    {
        $this->info('Revoking access to repositories for expired licenses...');

        License::query()
            ->whereHas('purchase', fn (Builder $query) => $query->where('has_repository_access', true))
            ->whereExpired()
            ->cursor()
            ->each(function (License $license) use ($gitHubApi) {
                if ($license->purchase->user->licenses()
                    ->whereNotExpired()
                    ->where('purchasable_id', $license->purchasable_id)
                    ->exists()) {
                    // User has another license for this repo
                    return;
                }

                try {
                    $gitHubApi->revokeAccessToRepo(
                        $license->purchase->user->github_username,
                        $license->purchase->purchasable->repository_access
                    );
                } catch (RuntimeException $e) {
                    if ($e->getMessage() !== "Not Found") {
                        $this->log::alert(
                            "We could not revoke access for {$license->purchase->user->github_username}
                             to {$license->purchase->purchasable->repository_access}"
                        );

                        return;
                    }

                    // User does not exist on Github anymore
                    $this->unsetGithubUsername($license->purchase->user);
                }

                $license->purchase->update(['has_repository_access' => false]);
            });

        $this->info('All done!');
    }

    private function unsetGithubUsername(User $user): void
    {
        $user->github_username = null;

        $user->save();
    }
}
