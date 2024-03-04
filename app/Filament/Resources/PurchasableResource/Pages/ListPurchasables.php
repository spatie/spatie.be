<?php

namespace App\Filament\Resources\PurchasableResource\Pages;

use App\Filament\Resources\PurchasableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchasables extends ListRecords
{
    protected static string $resource = PurchasableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
