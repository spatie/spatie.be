<?php

namespace App\Filament\Resources\Courses;

use App\Filament\Resources\Courses\CommentResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Spatie\Comments\Models\Comment;
use function Clue\StreamFilter\fun;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationGroup = 'Courses';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->state(fn(Comment $record) => $record->topLevel()->commentable?->commentableName() ?? 'Deleted...'),
                Tables\Columns\TextColumn::make('commentator.email')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('show')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Comment $record): string => $record->commentUrl())
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
