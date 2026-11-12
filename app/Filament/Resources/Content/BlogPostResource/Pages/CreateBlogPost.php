<?php

namespace App\Filament\Resources\Content\BlogPostResource\Pages;

use App\Domain\Blog\Actions\SaveBlogPostAction;
use App\Domain\Blog\Models\BlogPost;
use App\Filament\Resources\Content\BlogPostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return app(SaveBlogPostAction::class)->execute(new BlogPost(), $data);
    }

    protected function getRedirectUrl(): string
    {
        return BlogPostResource::getUrl('edit', ['record' => $this->record]);
    }
}
