<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Spatie\FilamentSimpleStats\SimpleStat;

class SalesStatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            SimpleStat::make(User::class)->last30Days()->dailyCount(),
//            SimpleStat::make(User::class)->last30Days()->dailyAverage(),
//            SimpleStat::make(User::class)->last30Days()->hourlyAverage(),
//            SimpleStat::createdInPastDays(Purchase::class),
        ];
    }
}
