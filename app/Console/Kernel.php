<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('import:github-issues')->hourly();
        $schedule->command('import:insights')->hourly();
        $schedule->command('import:random-contributor')->hourly();
        $schedule->command('import:packagist-downloads')->hourly();
        $schedule->command('import:github-repositories')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
