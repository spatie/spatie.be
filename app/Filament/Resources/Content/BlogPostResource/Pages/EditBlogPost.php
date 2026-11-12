<?php

namespace App\Filament\Resources\Content\BlogPostResource\Pages;

use App\Domain\Blog\Actions\SaveBlogPostAction;
use App\Filament\Resources\Content\BlogPostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(SaveBlogPostAction::class)->execute($record, $data);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')->url(fn () => route('blog.preview', $this->record))->openUrlInNewTab(),
            DeleteAction::make()->after(fn () => Cache::forget('home.blogPosts')),
        ];
    }
}
