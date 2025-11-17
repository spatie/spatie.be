<?php

namespace App\Filament\Resources\Customers\LicenseResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Customers\LicenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLicenses extends ListRecords
{
    protected static string $resource = LicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
