<?php

namespace App\Filament\Resources\Shop\BundlePriceResource\Pages;

use App\Filament\Resources\Shop\BundlePriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBundlePrice extends EditRecord
{
    protected static string $resource = BundlePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
