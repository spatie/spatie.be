<?php

namespace App\Filament\Resources\Shop\BundleResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Shop\BundleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBundle extends EditRecord
{
    protected static string $resource = BundleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
