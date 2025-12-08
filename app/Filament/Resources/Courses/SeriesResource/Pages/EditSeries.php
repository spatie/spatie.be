<?php

namespace App\Filament\Resources\Courses\SeriesResource\Pages;

use App\Filament\Resources\Courses\SeriesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSeries extends EditRecord
{
    protected static string $resource = SeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
