<?php

namespace App\Filament\Resources\Courses\SeriesResource\Pages;

use App\Filament\Resources\Courses\SeriesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeries extends ListRecords
{
    protected static string $resource = SeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
