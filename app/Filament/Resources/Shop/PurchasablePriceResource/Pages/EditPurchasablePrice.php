<?php

namespace App\Filament\Resources\Shop\PurchasablePriceResource\Pages;

use App\Filament\Resources\Shop\PurchasablePriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchasablePrice extends EditRecord
{
    protected static string $resource = PurchasablePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
