<?php

namespace App\Console;

use App\Console\Commands\ImportDocsFromRepositoriesCommand;
use App\Console\Commands\ImportGitHubRepositoriesCommand;
use App\Console\Commands\ImportGuideLinesCommand;
use App\Console\Commands\ImportInsightsCommand;
use App\Console\Commands\ImportPackagistDownloadsCommand;
use App\Domain\Shop\Commands\RevokeRepositoryAccessForExpiredLicensesCommand;
use App\Domain\Shop\Commands\SendLicenseExpirationNotificationsCommand;
use App\Domain\Shop\Commands\UpdateBundlePricesCommand;
use App\Domain\Shop\Commands\UpdateConversionRatesCommand;
use App\Domain\Shop\Commands\UpdatePurchasablePricesCommand;
use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ScheduleMonitor\Commands\CleanLogCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:send-email-list-summary-mail')->mondays()->at('9:00');
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
        $schedule->command('mailcoach:cleanup-processed-feedback')->hourly();
        $schedule->command('mailcoach:run-automation-triggers')->everyMinute()->runInBackground();
        $schedule->command('mailcoach:run-automation-actions')->everyMinute()->runInBackground();
        $schedule->command('mailcoach:calculate-automation-mail-statistics')->everyMinute();

        $schedule->command(ImportInsightsCommand::class)->hourly();
        $schedule->command(ImportPackagistDownloadsCommand::class)->hourly();
        $schedule->command(ImportGitHubRepositoriesCommand::class)->weekly();
        $schedule->command(ImportGuideLinesCommand::class)->weekly();

        $schedule->command(CleanLogCommand::class)->weekly();
        $schedule->command(SendLicenseExpirationNotificationsCommand::class)->dailyAt('10:00');
        $schedule->command(RevokeRepositoryAccessForExpiredLicensesCommand::class)->dailyAt('04:00');
        $schedule->command(ImportDocsFromRepositoriesCommand::class)->runInBackground()->daily();
        $schedule->job(RandomizeAdsOnGitHubRepositoriesJob::class)->weekly();
        $schedule->command(UpdateConversionRatesCommand::class)->runInBackground()->sundays()->at('05:00');
        $schedule->command(UpdatePurchasablePricesCommand::class)->runInBackground()->sundays()->at('06:00');
        $schedule->command(UpdateBundlePricesCommand::class)->runInBackground()->sundays()->at('06:30');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        $this->load(__DIR__ . '/../Domain/Shop/Commands');

        require base_path('routes/console.php');
    }
}
