<?php

namespace App\Console;

use App\Console\Commands\ImportGitHubIssues;
use App\Console\Commands\ImportGitHubRepositories;
use App\Console\Commands\ImportInsights;
use App\Console\Commands\ImportPackagistDownloads;
use App\Console\Commands\ImportRandomContributor;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:send-email-list-summary-mail')->mondays()->at('9:00');
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();

        $schedule->command(ImportGitHubIssues::class)->hourly();
        $schedule->command(ImportInsights::class)->hourly();
        $schedule->command(ImportRandomContributor::class)->hourly();
        $schedule->command(ImportPackagistDownloads::class)->hourly();
        $schedule->command(ImportGitHubRepositories::class)->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
