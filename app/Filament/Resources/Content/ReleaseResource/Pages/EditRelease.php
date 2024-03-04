<?php

namespace App\Filament\Resources\Content\ReleaseResource\Pages;

use App\Filament\Resources\Content\ReleaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRelease extends EditRecord
{
    protected static string $resource = ReleaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
