<?php

namespace App\Filament\Resources\Content\PostcardResource\Pages;

use App\Filament\Resources\Content\PostcardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPostcards extends ListRecords
{
    protected static string $resource = PostcardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
