<?php

namespace App\Console\Commands;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Exception;
use Illuminate\Console\Command;

class RestoreRepositoryAccessForUserCommand extends Command
{
    protected $signature = 'app:restore-repository-access-for-user-command {userId}';

    protected $description = 'Restore repository access for a user, with detailed output for debugging';

    public function handle(GitHubApi $gitHubApi): void
    {
        $user = User::findOrFail($this->argument('userId'));

        $this->info("User #{$user->id}: {$user->email}");
        $this->info("GitHub username: " . ($user->github_username ?: '(not set)'));

        if (! $user->github_username) {
            $this->error('User has no GitHub username set. Cannot restore access.');

            return;
        }

        $this->newLine();

        $allAssignments = $user->assignments()->with(['purchasable.product', 'licenses'])->get();

        $this->info("Total assignments: {$allAssignments->count()}");

        $allAssignments->each(function (PurchaseAssignment $assignment) {
            $this->newLine();
            $this->warn("Assignment #{$assignment->id}");
            $this->line("  Purchasable: #{$assignment->purchasable_id} - {$assignment->purchasable->getFullTitle()}");
            $this->line("  has_repository_access: " . ($assignment->has_repository_access ? 'true' : 'false'));
            $this->line("  repository_access: " . ($assignment->purchasable->repository_access ?: '(empty)'));
            $this->line("  requires_license: " . ($assignment->purchasable->requires_license ? 'true' : 'false'));
            $this->line("  is_renewal: " . ($assignment->purchasable->isRenewal() ? 'true' : 'false'));
            $this->line("  Licenses: {$assignment->licenses->count()}");

            $assignment->licenses->each(function ($license) {
                $expired = $license->isExpired() ? 'EXPIRED' : 'ACTIVE';
                $this->line("    License #{$license->id} | expires_at: {$license->expires_at} | {$expired}");
            });
        });

        $this->newLine();
        $this->info('--- Processing assignments with active licenses ---');

        $invited = false;

        $allAssignments->each(function (PurchaseAssignment $assignment) use ($user, $gitHubApi, &$invited) {
            if (! $assignment->purchasable->repository_access) {
                return;
            }

            $hasActiveLicense = $assignment->licenses()
                ->whereNotExpired()
                ->exists();

            if ($assignment->purchasable->requires_license && ! $hasActiveLicense) {
                return;
            }

            $this->newLine();
            $this->warn("Processing Assignment #{$assignment->id} ({$assignment->purchasable->getFullTitle()})");
            $this->line("  has_repository_access flag: " . ($assignment->has_repository_access ? 'true' : 'false'));

            $repositories = array_map('trim', explode(',', $assignment->purchasable->repository_access));

            foreach ($repositories as $repository) {
                if (empty($repository)) {
                    continue;
                }

                $this->info("  Inviting {$user->github_username} to {$repository}...");

                try {
                    $gitHubApi->inviteToRepo($user->github_username, $repository);
                    $this->info("  SUCCESS: Invited to {$repository}");
                    $invited = true;
                } catch (Exception $exception) {
                    $this->error("  FAILED: {$exception->getMessage()}");

                    return;
                }
            }

            $assignment->update(['has_repository_access' => true]);
            $this->info("  Updated has_repository_access = true");
        });

        if (! $invited) {
            $this->newLine();
            $this->error('No assignments with active licenses and repository_access found.');
        }

        $this->newLine();
        $this->info('Done.');
    }
}
