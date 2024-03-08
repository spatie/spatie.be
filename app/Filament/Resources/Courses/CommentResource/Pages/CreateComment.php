<?php

namespace App\Filament\Resources\Courses\CommentResource\Pages;

use App\Filament\Resources\Courses\CommentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;
}
