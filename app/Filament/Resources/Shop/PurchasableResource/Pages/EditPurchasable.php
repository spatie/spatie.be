<?php

namespace App\Filament\Resources\Shop\PurchasableResource\Pages;

use App\Filament\Resources\Shop\PurchasableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchasable extends EditRecord
{
    protected static string $resource = PurchasableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
