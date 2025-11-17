<?php

namespace App\Filament\Resources\Customers\ReceiptResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Customers\ReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceipts extends ListRecords
{
    protected static string $resource = ReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
