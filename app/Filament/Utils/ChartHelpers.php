<?php

namespace App\Filament\Utils;

class ChartHelpers
{
    public static function chartColors(): array
    {
        return [
            '#4dc9f6',
            '#f67019',
            '#f87171',
            '#537bc4',
            '#acc236',
            '#166a8f',
            '#00a950',
            '#58595b',
            '#8549ba',
            '#6366f1',
            '#bef264',
        ];
    }

    public static function chartColor(int $i): string
    {
        if ($i >= count(static::chartColors())) {
            $i = 0;
        }

        return static::chartColors()[$i];
    }
}
