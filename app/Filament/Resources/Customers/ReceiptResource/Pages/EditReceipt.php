<?php

namespace App\Filament\Resources\Customers\ReceiptResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Customers\ReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceipt extends EditRecord
{
    protected static string $resource = ReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
