<?php

namespace App\Filament\Resources\Courses\CommentResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Courses\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
