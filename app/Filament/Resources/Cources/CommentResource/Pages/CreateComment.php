<?php

namespace App\Filament\Resources\Cources\CommentResource\Pages;

use App\Filament\Resources\Cources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;
}
