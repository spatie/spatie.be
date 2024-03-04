<?php

namespace App\Filament\Resources\Cources\SeriesResource\Pages;

use App\Filament\Resources\Cources\SeriesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeries extends EditRecord
{
    protected static string $resource = SeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
