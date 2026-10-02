<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class HealthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Health::checks([
            DebugModeCheck::new(),
            OptimizedAppCheck::new()
                ->checkEvents()
                ->checkConfig(),
            EnvironmentCheck::new(),
            DatabaseCheck::new(),
            ...$this->serverChecks(),
        ]);
    }

    /**
     * On Laravel Cloud, queues are managed queues instead of Horizon, and
     * the replicas' load and disk space are managed by Cloud.
     *
     * @return array<int, Check>
     */
    protected function serverChecks(): array
    {
        if (laravel_cloud()) {
            return [];
        }

        return [
            CpuLoadCheck::new()->failWhenLoadIsHigherInTheLast5Minutes(5.0),
            HorizonCheck::new(),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),
        ];
    }
}
