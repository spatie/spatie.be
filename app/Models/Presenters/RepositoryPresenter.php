<?php

namespace App\Models\Presenters;

trait RepositoryPresenter
{
    public static function humanReadableDownloadCount(): string
    {
        $totalDownloads = static::getTotalDownloads();

        $step = 1_000_000_000;

        $approximateBillions = number_format($totalDownloads / $step, 2);

        return $approximateBillions . ' billion';
    }
}
