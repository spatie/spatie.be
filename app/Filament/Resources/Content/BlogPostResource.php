<?php

namespace App\Filament\Resources\Content;

use App\Domain\Blog\Actions\AddBlogMediaAction;
use App\Domain\Blog\Models\BlogPost;
use App\Filament\Resources\Content\BlogPostResource\Pages\CreateBlogPost;
use App\Filament\Resources\Content\BlogPostResource\Pages\EditBlogPost;
use App\Filament\Resources\Content\BlogPostResource\Pages\ListBlogPosts;
use App\Models\Member;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make('Post')->schema([
                TextInput::make('title')->required()->maxLength(255)->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                        if (! $get('slug')) {
                            $set('slug', Str::slug($state ?? ''));
                        }
                    }),
                TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true)
                    ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                    ->rules([Rule::notIn(['all', 'authors'])])
                    ->disabled(fn (?BlogPost $record): bool => (bool) $record?->first_published_at),
                Toggle::make('published')->default(false)->live(),
                DateTimePicker::make('published_at')->label('Publication date (UTC)')->timezone('UTC')->seconds(false)
                    ->required(fn (Get $get): bool => (bool) $get('published'))
                    ->helperText('Published posts with a future date stay hidden until that time.'),
                Repeater::make('author_data')->label('Authors')->defaultItems(0)->schema([
                    Select::make('member')->label('Copy a team member')->dehydrated(false)
                        ->options(fn () => Member::query()->orderBy('first_name')->get()->pluck('full_name', 'id'))
                        ->live()->afterStateUpdated(function ($state, Set $set): void {
                            if ($member = Member::find($state)) {
                                $set('name', $member->first_name);
                                $set('gravatar_url', $member->author_gravatar_url);
                            }
                        }),
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('gravatar_url')->label('Avatar URL')->url()->maxLength(2048),
                ]),
                TagsInput::make('tags'),
                MarkdownEditor::make('summary_markdown')->label('Summary')->fileAttachments(false),
                MarkdownEditor::make('markdown')->label('Content')->required()->minHeight('500px')
                    ->fileAttachments(fn (?BlogPost $record): bool => (bool) $record?->exists)
                    ->fileAttachmentsAcceptedFileTypes(['image/png', 'image/jpeg', 'image/gif', 'image/webp', 'image/avif'])
                    ->fileAttachmentsMaxSize(12288)
                    ->saveUploadedFileAttachmentUsing(fn (TemporaryUploadedFile $file, BlogPost $record) => app(AddBlogMediaAction::class)->execute($record, $file)->getUrl())
                    ->getFileAttachmentUrlUsing(fn (string $file): string => $file)
                    ->helperText('Save a draft before uploading images. Saving a published post changes it immediately. Uploaded files are public, including draft attachments.'),
            ]),
            Section::make('Media')->visible(fn (?BlogPost $record): bool => (bool) $record?->exists)->schema([
                static::upload('header')->label('Header image')->image(),
                static::upload('og')->label('Social image')->image(),
                static::upload('attachments')->label('Post uploads')->multiple(),
                Select::make('insert_media_id')->label('Insert a saved upload')->dehydrated(false)->searchable()
                    ->options(fn (BlogPost $record) => $record->media()->orderByDesc('id')->pluck('name', 'id')),
                TextInput::make('image_description')->label('Image description (alt text)')->dehydrated(false),
                Actions::make([
                    Action::make('insertMedia')->action(function (BlogPost $record, Get $get, Set $set): void {
                        if (! $media = $record->media()->find($get('insert_media_id'))) {
                            return;
                        }

                        $url = $media->getUrl();
                        $alt = str_replace(['[', ']'], ['\\[', '\\]'], $get('image_description') ?? '');
                        $snippet = match (true) {
                            str_starts_with($media->mime_type, 'image/') => "![{$alt}]({$url})",
                            str_starts_with($media->mime_type, 'video/') => '<video controls preload="metadata"><source src="'.e($url).'" type="'.e($media->mime_type).'"></video>',
                            default => "[{$alt}]({$url})",
                        };
                        $set('markdown', rtrim($get('markdown') ?? '')."\n\n{$snippet}\n");
                    }),
                ]),
            ])->description('Save uploads before inserting them. Replaced headers are retained so existing links keep working.'),
        ]);
    }

    protected static function upload(string $collection): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make($collection)
            ->collection($collection)->disk('medialibrary')->maxSize(12288)
            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/gif', 'image/webp', 'image/avif', 'video/mp4', 'video/webm', 'application/pdf'])
            ->deletable($collection !== 'attachments')->openable()->downloadable()
            ->filterMediaUsing(fn ($media) => $collection === 'attachments' ? $media : $media->sortByDesc('id')->take(1))
            ->saveRelationshipsUsing(function (SpatieMediaLibraryFileUpload $component, BlogPost $record) use ($collection): void {
                if ($collection !== 'attachments') {
                    $record->getMedia($collection)
                        ->whereNotIn('uuid', array_keys($component->getRawState() ?? []))
                        ->each(fn ($media) => $media->update(['collection_name' => 'attachments']));
                }

                $component->saveUploadedFiles();
            })
            ->saveUploadedFileUsing(fn (TemporaryUploadedFile $file, BlogPost $record) => app(AddBlogMediaAction::class)->execute($record, $file, $collection)->uuid);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable()->sortable(),
            IconColumn::make('published')->boolean(),
            TextColumn::make('published_at')->dateTime()->sortable(),
        ])->filters([TernaryFilter::make('published')])
            ->recordActions([EditAction::make()])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogPosts::route('/'),
            'create' => CreateBlogPost::route('/create'),
            'edit' => EditBlogPost::route('/{record}/edit'),
        ];
    }
}
