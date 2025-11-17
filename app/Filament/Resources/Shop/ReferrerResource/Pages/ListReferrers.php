<?php

namespace App\Filament\Resources\Shop\ReferrerResource\Pages;

use App\Filament\Resources\Shop\ReferrerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReferrers extends ListRecords
{
    protected static string $resource = ReferrerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
