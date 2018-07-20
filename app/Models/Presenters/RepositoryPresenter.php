<?php

namespace App\Models\Presenters;

trait RepositoryPresenter
{
    public function getFormattedStarsAttribute(): string
    {
        return number_format($this->stars, 0, '.', ' ');
    }

    public function getFormattedDownloadsAttribute(): string
    {
        return number_format($this->downloads, 0, '.', ' ');
    }

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
