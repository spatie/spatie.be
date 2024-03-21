<?php

namespace App\Filament\Widgets;

use App\Domain\Shop\Models\Purchase;
use App\Filament\SimpleStat;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SalesStatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            SimpleStat::createdInPastDays(User::class),
            SimpleStat::createdInPastDays(Purchase::class),
        ];
    }
}
