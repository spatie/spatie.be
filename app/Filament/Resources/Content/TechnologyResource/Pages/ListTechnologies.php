<?php

namespace App\Filament\Resources\Content\TechnologyResource\Pages;

use App\Filament\Resources\Content\TechnologyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTechnologies extends ListRecords
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
