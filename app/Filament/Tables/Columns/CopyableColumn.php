<?php

namespace App\Filament\Tables\Columns;

use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;

class CopyableColumn
{
    public static function make(string $name)
    {
        return TextColumn::make($name)
            ->iconPosition(IconPosition::After)
            ->copyable()
            ->icon('heroicon-o-document-duplicate');
    }
}
