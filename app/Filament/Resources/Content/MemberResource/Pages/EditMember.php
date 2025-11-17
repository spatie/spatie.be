<?php

namespace App\Filament\Resources\Content\MemberResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Content\MemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMember extends EditRecord
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
