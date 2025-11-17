<?php

namespace App\Filament\Resources\Customers\PurchaseResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Customers\PurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchases extends ListRecords
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
