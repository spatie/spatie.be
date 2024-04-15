<?php

namespace App\Filament\Tables\Columns;

use App\Domain\Shop\Models\License;

class LicensePurchasableNameColumn
{
    public static function make()
    {
        return ResourceLinkColumn::make(
            'assignment.purchasable.title',
            function (License $record) {
                if(! $record->assignment) {
                    return null;
                }

                return route('filament.admin.resources.customers.purchase-assignments.edit', $record->assignment);
            }
        )
            ->state(function (License $record) {
                if ($record->assignment?->purchasable) {
                    return $record->assignment->purchasable->title ." ({$record->assignment->purchasable->product->title})";
                }

                if ($record->assignment?->bundle) {
                    return $record->assignment->bundle->title . " ({$record->assignment->bundle->formattedProductNames()})";
                }

                return '-';
            })->sortable()->searchable();
    }
}
