<?php

namespace App\Filament;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Str;

class SimpleStat
{
    public static function createdInPastDays(string $model, int $days = 30): Stat
    {
        $perDayTrend = Trend::model($model)
            ->between(
                start: now()->subDays($days - 1),
                end: now(),
            )
            ->perDay()
            ->count();

        $total = $model::whereBetween(
            column: 'created_at',
            values: [now()->subDays($days - 1), now()],
        )->count();

        return Stat::make('New ' . self::getEntityTitleFromModel($model), $total)
            ->chart($perDayTrend->map(fn (TrendValue $trend) => $trend->aggregate)->toArray())
            ->description('Last 30 days');
    }

    protected static function getEntityTitleFromModel(string $model): string
    {
        $pieces = explode('\\', $model);
        return Str::plural(end($pieces));
    }
}
