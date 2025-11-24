<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\PlaylistResource\Pages\CreatePlaylist;
use App\Filament\Resources\Content\PlaylistResource\Pages\EditPlaylist;
use App\Filament\Resources\Content\PlaylistResource\Pages\ListPlaylists;
use App\Models\Playlist;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlaylistResource extends Resource
{
    protected static ?string $model = Playlist::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-musical-note';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                TextInput::make('spotify_url')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('apple_music_url')
                    ->columnStart(1)
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->columnStart(1)
                    ->maxFiles(1)
                    ->rules(['image'])
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('spotify_url')
                    ->url(fn ($record) => $record->spotify_url)
                    ->openUrlInNewTab()
                    ->searchable()
                    ->limit(20)
                    ->icon('heroicon-o-arrow-up-right')
                    ->iconPosition(IconPosition::After)
                    ->sortable(),
                TextColumn::make('apple_music_url')
                    ->url(fn ($record) => $record->apple_music_url)
                    ->openUrlInNewTab()
                    ->limit(20)
                    ->icon('heroicon-o-arrow-up-right')
                    ->iconPosition(IconPosition::After)
                    ->searchable()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('image'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ListPlaylists::route('/'),
            'create' => CreatePlaylist::route('/create'),
            'edit' => EditPlaylist::route('/{record}/edit'),
        ];
    }
}
