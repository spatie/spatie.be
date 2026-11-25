<?php

namespace App\Filament\Resources\AdminAccessResource\Pages;

use App\Filament\Resources\AdminAccessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAdminAccess extends ManageRecords
{
    protected static string $resource = AdminAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add address')
                ->modalHeading('Add admin access')
                ->modalSubmitActionLabel('Add address')
                ->createAnother(false)
                ->successNotificationTitle('Admin access added'),
        ];
    }
}
