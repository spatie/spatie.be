<?php

namespace App\Filament\Resources\Customers\UserResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Customers\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
