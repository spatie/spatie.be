<?php

namespace App\Filament\Resources\Customers\PurchaseResource\Columns;

use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Filament\Tables\Columns\ResourceLinkColumn;

class BoughtColumn
{
    public static function make()
    {
        return ResourceLinkColumn::make('Bought')->state(function (Purchase|PurchaseAssignment $record) {
            if ($record->purchasable) {
                return $record->purchasable->title ." ({$record->purchasable->product->title})";
            }

            if ($record->bundle) {
                return $record->bundle->title . " ({$record->bundle->formattedProductNames()})";
            }

            return '-';
        })->url(function (Purchase|PurchaseAssignment $record) {
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
