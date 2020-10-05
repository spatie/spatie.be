<?php

namespace App\Console;

use App\Console\Commands\ImportDocsFromRepositoriesCommand;
use App\Console\Commands\ImportGitHubRepositoriesCommand;
use App\Console\Commands\ImportInsightsCommand;
use App\Console\Commands\ImportPackagistDownloadsCommand;
use App\Console\Commands\SendLicenseExpirationNotificationsCommand;
use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
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
        $schedule->command('mailcoach:cleanup-processed-feedback')->hourly();

        $schedule->command(ImportInsightsCommand::class)->hourly();
        $schedule->command(ImportPackagistDownloadsCommand::class)->hourly();
        $schedule->command(ImportGitHubRepositoriesCommand::class)->weekly();

        $schedule->command(SendLicenseExpirationNotificationsCommand::class)->dailyAt('10:00');
        $schedule->command(ImportDocsFromRepositoriesCommand::class)->everyThirtyMinutes();
        $schedule->job(RandomizeAdsOnGitHubRepositoriesJob::class)->weekly();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
