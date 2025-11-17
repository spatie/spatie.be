<?php

namespace App\Filament\Resources\Shop\BundlePriceResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Shop\BundlePriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBundlePrices extends ListRecords
{
    protected static string $resource = BundlePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
