<?php

namespace App\Filament\Resources\Content\TechnologyResource\Pages;

use App\Filament\Resources\Content\TechnologyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTechnology extends EditRecord
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
