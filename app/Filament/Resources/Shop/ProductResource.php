<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Product;
use App\Filament\Resources\Shop\ProductResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('id')
                            ->disabled(),
                        SpatieMediaLibraryFileUpload::make('product_image')
                            ->collection('product-image')
                            ->maxFiles(1)
                            ->rules(['image'])
                            ->columnStart(1),
                        TextInput::make('title')
                            ->columnStart(1),
                        TextInput::make('slug')
                            ->columnStart(1),
                        RichEditor::make('description')
                            ->columnSpan(2),
                        RichEditor::make('long_description')
                            ->columnSpan(2),
                        TextInput::make('url')
                            ->columnStart(1),
                        TextInput::make('action_label')
                            ->columnStart(1),
                        TextInput::make('action_url')
                            ->default(''),
                        TextInput::make('maximum_activation_count')->integer(),
                        Toggle::make('visible')
                            ->columnStart(1),
                        Toggle::make('external')
                            ->columnStart(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                SpatieMediaLibraryImageColumn::make('product_image')->collection('product-image'),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                BooleanColumn::make('visible')->label('Visible on Front')->sortable(),
                Tables\Columns\TextColumn::make('purchasablesWithoutRenewals.title')
                    ->listWithLineBreaks()->bulleted(),
                Tables\Columns\TextColumn::make('renewals.title')
                    ->listWithLineBreaks()->bulleted(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
