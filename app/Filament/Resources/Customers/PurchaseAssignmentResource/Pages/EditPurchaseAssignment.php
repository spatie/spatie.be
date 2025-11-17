<?php

namespace App\Filament\Resources\Customers\PurchaseAssignmentResource\Pages;

use App\Filament\Resources\Customers\PurchaseAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseAssignment extends EditRecord
{
    protected static string $resource = PurchaseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($license = $this->record->licenses?->first()) {
            $data['license_expires_at'] = $license->expires_at;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $licenseExpiresAt = $this->form->getState()['license_expires_at'] ?? null;

        if ($licenseExpiresAt && $license = $this->record->licenses?->first()) {
            $license->update(['expires_at' => $licenseExpiresAt]);
        }
    }
}
