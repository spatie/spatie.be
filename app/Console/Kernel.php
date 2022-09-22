<?php

namespace App\Console;

use App\Console\Commands\ImportDocsFromRepositoriesCommand;
use App\Console\Commands\ImportGitHubRepositoriesCommand;
use App\Console\Commands\ImportGuideLinesCommand;
use App\Console\Commands\ImportInsightsCommand;
use App\Console\Commands\ImportPackagistDownloadsCommand;
use App\Console\Commands\RegenerateLeakedKeysCommand;
use App\Console\Commands\WishHappyBirthdayCommand;
use App\Domain\Shop\Commands\RevokeRepositoryAccessForExpiredLicensesCommand;
use App\Domain\Shop\Commands\SendLicenseExpirationNotificationsCommand;
use App\Domain\Shop\Commands\UpdateBundlePricesCommand;
use App\Domain\Shop\Commands\UpdateConversionRatesCommand;
use App\Domain\Shop\Commands\UpdatePurchasablePricesCommand;
use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(ImportInsightsCommand::class)->hourly();
        $schedule->command(ImportPackagistDownloadsCommand::class)->hourly();
        $schedule->command(ImportGitHubRepositoriesCommand::class)->weekly();
        $schedule->command(ImportGuideLinesCommand::class)->weekly();
        $schedule->command(RegenerateLeakedKeysCommand::class)->runInBackground()->hourly();

        $schedule->command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->weekly();
        $schedule->command(SendLicenseExpirationNotificationsCommand::class)->dailyAt('10:00');
        $schedule->command(RevokeRepositoryAccessForExpiredLicensesCommand::class)->dailyAt('04:00');
        $schedule->command(ImportDocsFromRepositoriesCommand::class)->graceTimeInMinutes(20)->runInBackground();
        $schedule->job(RandomizeAdsOnGitHubRepositoriesJob::class)->weekly();
        $schedule->command(UpdateConversionRatesCommand::class)->runInBackground()->sundays()->at('05:00');
        $schedule->command(UpdatePurchasablePricesCommand::class)->runInBackground()->sundays()->at('06:00');
        $schedule->command(UpdateBundlePricesCommand::class)->runInBackground()->sundays()->at('06:30');
        $schedule->command('geoip:update')->weekly();

        $schedule->command(WishHappyBirthdayCommand::class)->runInBackground()->dailyAt('08:50');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        $this->load(__DIR__ . '/../Domain/Shop/Commands');

        require base_path('routes/console.php');
    }
}
