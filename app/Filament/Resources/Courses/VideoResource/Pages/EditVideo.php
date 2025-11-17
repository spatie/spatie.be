<?php

namespace App\Filament\Resources\Courses\VideoResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Courses\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideo extends EditRecord
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
