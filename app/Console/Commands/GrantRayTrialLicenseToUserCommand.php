<?php

namespace App\Console\Commands;

use App\Actions\GrantRayTrialLicenseAction;
use App\Models\User;
use Illuminate\Console\Command;

class GrantRayTrialLicenseToUserCommand extends Command
{
    protected $signature = 'grant-ray-trial {--user=}';

    public function handle(): void
    {
        $this->info('Finding user...');

        $user = User::findOrFail($this->option('user'));

        $license = app(GrantRayTrialLicenseAction::class)->execute($user);

        $license
            ? $this->info('Added trial license!')
            : $this->warn('Did not add trial license...');
    }
}
