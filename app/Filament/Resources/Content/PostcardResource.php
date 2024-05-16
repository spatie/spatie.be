<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\PostcardResource\Pages;
use App\Models\Postcard;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class PostcardResource extends Resource
{
    protected static ?string $model = Postcard::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sender')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('country')->searchable()->sortable(),
                SpatieMediaLibraryImageColumn::make('front_image'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPostcards::route('/'),
            'create' => Pages\CreatePostcard::route('/create'),
            'edit' => Pages\EditPostcard::route('/{record}/edit'),
        ];
    }
}
