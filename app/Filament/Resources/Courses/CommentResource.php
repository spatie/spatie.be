<?php

namespace App\Filament\Resources\Courses;

use App\Filament\Resources\Courses\CommentResource\Pages\CreateComment;
use App\Filament\Resources\Courses\CommentResource\Pages\EditComment;
use App\Filament\Resources\Courses\CommentResource\Pages\ListComments;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Comments\Models\Comment;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Courses';

    protected static ?int $navigationSort = 3;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                TextColumn::make('title')
                    ->state(fn (Comment $record) => $record->topLevel()->commentable?->commentableName() ?? 'Deleted...'),
                TextColumn::make('commentator.email')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('show')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Comment $record): string => $record->commentUrl())
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComments::route('/'),
            'create' => CreateComment::route('/create'),
            'edit' => EditComment::route('/{record}/edit'),
        ];
    }
}
