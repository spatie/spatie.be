<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Product;
use App\Filament\Resources\Shop\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\Shop\ProductResource\Pages\EditProduct;
use App\Filament\Resources\Shop\ProductResource\Pages\ListProducts;
use App\Filament\Tables\Columns\BooleanColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Products';

    protected static ?int $navigationSort = 1;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-gift';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                TextColumn::make('id')->searchable()->sortable(),
                SpatieMediaLibraryImageColumn::make('product_image')->collection('product-image'),
                TextColumn::make('title')->searchable()->sortable(),
                BooleanColumn::make('visible')->label('Visible on Front')->sortable(),
                TextColumn::make('purchasablesWithoutRenewals.title')
                    ->listWithLineBreaks()->bulleted(),
                TextColumn::make('renewals.title')
                    ->listWithLineBreaks()->bulleted(),
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
            ])
            ->reorderable('sort_order');
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
