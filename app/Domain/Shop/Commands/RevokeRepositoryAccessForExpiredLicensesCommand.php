<?php

namespace App\Domain\Shop\Commands;

use App\Domain\Shop\Exceptions\CouldNotRevokeRepositoryAccess;
use App\Domain\Shop\Models\License;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

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

                $user = $license->assignment->user;

                if (! $user->github_username) {
                    return;
                }

                try {
                    $gitHubUsername = $this->currentGitHubUsername($user, $gitHubApi);

                    if (! $gitHubUsername) {
                        $this->unsetGithubUsername($user);

                        $license->assignment->update(['has_repository_access' => false]);

                        return;
                    }

                    $repositories = array_map('trim', explode(',', $license->assignment->purchasable->repository_access));

                    foreach ($repositories as $repository) {
                        if (empty($repository)) {
                            // no defined repositories for this purchasable
                            $license->assignment()->update(['has_repository_access' => false]);

                            continue;
                        }

                        $gitHubApi->revokeAccessToRepo($gitHubUsername, $repository);
                    }
                } catch (Exception $exception) {
                    if ($exception->getMessage() !== 'Not Found') {
                        report(CouldNotRevokeRepositoryAccess::make(
                            $user->github_username,
                            $license->assignment->purchasable->repository_access,
                            $exception,
                        ));

                        return;
                    }

                    $this->unsetGithubUsername($user);
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
            ->whereHas('assignment', fn (Builder $query) => $query->where('purchasable_id', $license->assignment->purchasable_id))
            ->exists();
    }

    /**
     * When a user renamed their GitHub account, the stored username no longer
     * exists. Revoking access for it fails, while the renamed account keeps
     * access. We use the immutable GitHub id to find the current username.
     */
    protected function currentGitHubUsername(User $user, GitHubApi $gitHubApi): ?string
    {
        if ($gitHubApi->userExists($user->github_username)) {
            return $user->github_username;
        }

        if (! $user->github_id) {
            return null;
        }

        $currentGitHubUsername = $gitHubApi->getUsernameForId($user->github_id);

        if (! $currentGitHubUsername) {
            return null;
        }

        $user->update(['github_username' => $currentGitHubUsername]);

        return $currentGitHubUsername;
    }

    protected function unsetGithubUsername(User $user): void
    {
        $user->github_username = null;

        $user->save();
    }
}
