<?php

namespace App\Filament\Resources\Customers\UserResource\Pages;

use App\Filament\Resources\Customers\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Impersonate::make()->record($this->getRecord()),
        ];
    }
}
