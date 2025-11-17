<?php

namespace App\Filament\Resources\Shop\PurchasablePriceResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Shop\PurchasablePriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchasablePrices extends ListRecords
{
    protected static string $resource = PurchasablePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
