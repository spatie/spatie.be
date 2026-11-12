<?php

namespace App\Filament\Resources\Content\BlogPostResource\Pages;

use App\Filament\Resources\Content\BlogPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlogPosts extends ListRecords
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
