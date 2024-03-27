<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverviewWidget;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int | string | array
    {
        return 3;
    }
}
