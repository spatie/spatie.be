<?php

namespace App\Filament\Tables\Columns;

use App\Domain\Shop\Models\Purchase;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;

class ResourceLinkColumn
{
    public static function make(string $name, ?callable $url = null)
    {
        return TextColumn::make($name)
            ->color('primary')
            ->weight(FontWeight::Bold)
            ->url($url);
    }
}
