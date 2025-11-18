<?php

namespace App\Filament\Resources\Content\TechnologyResource\Pages;

use App\Filament\Resources\Content\TechnologyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTechnologies extends ListRecords
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
