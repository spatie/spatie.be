<?php

namespace App\Filament\Resources\Shop;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Shop\BundleResource\Pages\ListBundles;
use App\Filament\Resources\Shop\BundleResource\Pages\CreateBundle;
use App\Filament\Resources\Shop\BundleResource\Pages\EditBundle;
use App\Domain\Shop\Models\Bundle;
use App\Filament\Resources\Shop\BundleResource\Actions\UpdateBundlePriceForCurrencyAction;
use App\Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BundleResource extends Resource
{
    protected static ?string $model = Bundle::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Products';

    protected static ?int $navigationSort = 4;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->maxFiles(1)
                    ->rules(['image'])
                    ->columnStart(1),
                TextInput::make('title')
                    ->required()
                    ->columnStart(1),
                TextInput::make('slug')
                    ->required()
                    ->columnStart(1),
                TextInput::make('paddle_product_id')
                    ->required()
                    ->columnStart(1),

                MarkdownEditor::make('description')
                    ->columnSpan(2),
                MarkdownEditor::make('long_description')
                    ->columnSpan(2),

                TextInput::make('price_in_usd_cents')
                    ->integer()
                    ->required()
                    ->columnStart(1),

                Toggle::make('visible')
                    ->columnStart(1),

                Select::make('purchasables')
                    ->columnStart(1)
                    ->multiple()
                    ->relationship('purchasables', 'title'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('paddle_id')->searchable()->sortable(),
                TextColumn::make('price_in_usd_cents')->sortable(),
                BooleanColumn::make('visible')->label('Visible on Front')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                UpdateBundlePriceForCurrencyAction::make(),
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
            'index' => ListBundles::route('/'),
            'create' => CreateBundle::route('/create'),
            'edit' => EditBundle::route('/{record}/edit'),
        ];
    }
}
