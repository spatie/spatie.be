<?php

namespace App\Filament\Resources\Shop\BundleResource\Pages;

use App\Filament\Resources\Shop\BundleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBundles extends ListRecords
{
    protected static string $resource = BundleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
