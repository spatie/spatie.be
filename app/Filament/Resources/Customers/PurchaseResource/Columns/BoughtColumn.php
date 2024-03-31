<?php

namespace App\Filament\Resources\Customers\PurchaseResource\Columns;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Tables\Columns\ResourceLinkColumn;

class BoughtColumn
{
    public static function make()
    {
        return ResourceLinkColumn::make('Bought')->state(function (Purchase $record) {
            if ($record->purchasable) {
                return $record->purchasable->title;
            }

            if ($record->bundle) {
                return $record->bundle->title;
            }

            return '-';
        })->url(function (Purchase $record) {
            if ($record->purchasable) {
                return route('filament.admin.resources.shop.purchasables.edit', $record->purchasable);
            }

            if ($record->bundle) {
                return route('filament.admin.resources.shop.bundles.edit', $record->bundle);
            }

            return '';
        });
    }
}
