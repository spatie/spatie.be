<?php

namespace App\Filament\Resources\Content;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Content\PostcardResource\Pages\ListPostcards;
use App\Filament\Resources\Content\PostcardResource\Pages\CreatePostcard;
use App\Filament\Resources\Content\PostcardResource\Pages\EditPostcard;
use App\Filament\Resources\Content\PostcardResource\Pages;
use App\Models\Postcard;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class PostcardResource extends Resource
{
    protected static ?string $model = Postcard::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                TextInput::make('sender')
                    ->required(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('country')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('front_image')
                    ->disk('medialibrary')
                    ->responsiveImages()
                    ->maxFiles(1)
                    ->rules(['image'])
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                TextColumn::make('sender')->searchable()->sortable(),
                TextColumn::make('city')->searchable()->sortable(),
                TextColumn::make('country')->searchable()->sortable(),
                SpatieMediaLibraryImageColumn::make('front_image'),
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
            'index' => ListPostcards::route('/'),
            'create' => CreatePostcard::route('/create'),
            'edit' => EditPostcard::route('/{record}/edit'),
        ];
    }
}
