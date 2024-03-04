<?php

namespace App\Filament\Resources\PurchaseAssignmentResource\Pages;

use App\Filament\Resources\PurchaseAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseAssignment extends EditRecord
{
    protected static string $resource = PurchaseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
