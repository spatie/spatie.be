<?php

namespace App\Domain\Shop\Commands;

use App\Domain\Shop\Models\License;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class RevokeRepositoryAccessForExpiredLicensesCommand extends Command
{
    public $signature = 'revoke-repository-access-for-expired-licenses';

    public function handle(GitHubApi $gitHubApi): void
    {
        $this->info('Revoking access to repositories for expired licenses...');

        License::query()
            ->whereHas('assignment', fn (Builder $query) => $query->where('has_repository_access', true))
            ->whereExpired()
            ->cursor()
            ->each(function (License $license) use ($gitHubApi) {
                if ($this->userHasAnotherLicense($license)) {
                    return;
                }

                try {
                    $repositories = explode(', ', $license->assignment->purchasable->repository_access);

                    foreach($repositories as $repository) {
                        $gitHubApi->revokeAccessToRepo(
                            $license->assignment->user->github_username,
                            $repository
                        );
                    }
                } catch (RuntimeException $exception) {
                    if ($exception->getMessage() !== 'Not Found') {
                        Log::alert(
                            "We could not revoke access for {$license->assignment->user->github_username}
                             to {$license->assignment->purchasable->repository_access}. Exception: {$exception->getMessage()}"
                        );

                        return;
                    }

                    $this->unsetGithubUsername($license->assignment->user);
                }

                $license->assignment->update(['has_repository_access' => false]);
            });

        $this->info('All done!');
    }

    protected function userHasAnotherLicense(License $license): bool
    {
        return $license->assignment->user
            ->licenses()
            ->whereNotExpired()
            ->whereHas('assignment', fn (Builder $query) => $query->where('purchasable_id', $license->purchasable_id))
            ->exists();
    }

    protected function unsetGithubUsername(User $user): void
    {
        $user->github_username = null;

        $user->save();
    }
}
