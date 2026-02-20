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
        $this->info('--- Processing assignments with has_repository_access = false ---');

        $assignments = $user->assignments()
            ->with(['purchasable.product', 'licenses'])
            ->where('has_repository_access', false)
            ->get();

        if ($assignments->isEmpty()) {
            $this->warn('No assignments found with has_repository_access = false.');
            $this->warn('All assignments already have has_repository_access = true.');
            $this->warn('If the user still lacks access, their GitHub access was revoked but the flag was not updated.');
            $this->warn('Run: $user->assignments()->update(["has_repository_access" => false]) in tinker first, then re-run this command.');

            return;
        }

        $assignments->each(function (PurchaseAssignment $assignment) use ($user, $gitHubApi) {
            $this->newLine();
            $this->warn("Processing Assignment #{$assignment->id} ({$assignment->purchasable->getFullTitle()})");

            if (! $assignment->purchasable->repository_access) {
                $this->error("  SKIPPED: Purchasable has no repository_access configured.");

                return;
            }

            $this->info("  repository_access: {$assignment->purchasable->repository_access}");

            $hasActiveLicense = $assignment->licenses()
                ->whereNotExpired()
                ->exists();

            $this->line("  requires_license: " . ($assignment->purchasable->requires_license ? 'true' : 'false'));
            $this->line("  has active license on this assignment: " . ($hasActiveLicense ? 'true' : 'false'));

            if ($assignment->purchasable->requires_license && ! $hasActiveLicense) {
                $this->error("  SKIPPED: Requires license but no active license found on this assignment.");

                return;
            }

            $repositories = array_map('trim', explode(',', $assignment->purchasable->repository_access));

            foreach ($repositories as $repository) {
                if (empty($repository)) {
                    continue;
                }

                $this->info("  Inviting {$user->github_username} to {$repository}...");

                try {
                    $gitHubApi->inviteToRepo($user->github_username, $repository);
                    $this->info("  SUCCESS: Invited to {$repository}");
                } catch (Exception $exception) {
                    $this->error("  FAILED: {$exception->getMessage()}");

                    return;
                }
            }

            $assignment->update(['has_repository_access' => true]);
            $this->info("  Updated has_repository_access = true");
        });

        $this->newLine();
        $this->info('Done.');
    }
}
