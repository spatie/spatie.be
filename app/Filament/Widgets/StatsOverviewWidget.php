<?php

namespace App\Filament\Widgets;

use App\Domain\Shop\Models\Purchase;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Spatie\FilamentSimpleStats\SimpleStat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            SimpleStat::make(User::class)->last7Days()->dailyCount(),
            SimpleStat::make(Purchase::class)->last30Days()->dailySum('earnings'),
        ];
    }
}
