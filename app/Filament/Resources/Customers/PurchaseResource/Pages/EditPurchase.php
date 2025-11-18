<?php

namespace App\Filament\Resources\Customers\PurchaseResource\Pages;

use App\Filament\Resources\Customers\PurchaseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPurchase extends EditRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
