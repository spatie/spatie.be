<?php

namespace App\Filament\Resources\Content\AdResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Content\AdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAd extends EditRecord
{
    protected static string $resource = AdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
