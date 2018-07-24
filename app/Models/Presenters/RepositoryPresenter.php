<?php

namespace App\Models\Presenters;

trait RepositoryPresenter
{
    public static function humanReadableDownloadCount(): string
    {
        $totalDownloads = static::getTotalDownloads();

        $step = 1000000;

        $approximateMillions = number_format((int) round($totalDownloads / $step));

        $modulo = $totalDownloads % $step;

        if ($modulo <= $step / 2) {
            return 'more than ' .  $approximateMillions . ' million';
        }

        return 'almost' .  $approximateMillions . ' million';
    }
}
