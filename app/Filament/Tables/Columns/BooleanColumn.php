<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;

class BooleanColumn
{
    public static function make(string $name): Column
    {
        return IconColumn::make($name)
            ->icon(fn (bool|int $state): string => match ($state) {
                true, 1 => 'heroicon-o-check-circle',
                default => 'heroicon-o-x-circle',
            })
            ->color(fn (bool|int $state): string => match ($state) {
                true, 1 => 'success',
                default => 'danger',
            });
    }
}
