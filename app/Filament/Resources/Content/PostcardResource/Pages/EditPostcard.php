<?php

namespace App\Filament\Resources\Content\PostcardResource\Pages;

use App\Filament\Resources\Content\PostcardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPostcard extends EditRecord
{
    protected static string $resource = PostcardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
