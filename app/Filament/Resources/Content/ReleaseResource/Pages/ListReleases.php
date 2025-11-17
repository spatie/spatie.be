<?php

namespace App\Filament\Resources\Content\ReleaseResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Content\ReleaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReleases extends ListRecords
{
    protected static string $resource = ReleaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
