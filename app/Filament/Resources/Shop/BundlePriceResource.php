<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\BundlePrice;
use App\Filament\Resources\Shop\BundlePriceResource\Pages\CreateBundlePrice;
use App\Filament\Resources\Shop\BundlePriceResource\Pages\EditBundlePrice;
use App\Filament\Resources\Shop\BundlePriceResource\Pages\ListBundlePrices;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Support\Paddle\PaddleCountries;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BundlePriceResource extends Resource
{
    protected static ?string $model = BundlePrice::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Products';

    protected static ?int $navigationSort = 5;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-rupee';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('bundle_id')
                    ->relationship(name: 'bundle')
                    ->getOptionLabelFromRecordUsing(fn (Bundle $record) => $record->title)
                    ->columnStart(1),

                TextInput::make('country_code')
                    ->columnStart(1)
                    ->disabled(),

                TextInput::make('currency_code')
                    ->columnStart(1)
                    ->disabled(),

                TextInput::make('amount')
                    ->integer()
                    ->required()
                    ->columnStart(1),

                Toggle::make('overridden')
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                ResourceLinkColumn::make('bundle.title', fn (BundlePrice $record) => route('filament.admin.resources.shop.bundles.edit', $record->bundle)),
                TextColumn::make('country')->state(fn (BundlePrice $record) => PaddleCountries::getNameForCode($record->country_code) . "($record->country_code)")->searchable()->sortable(),
                TextColumn::make('currency_code')->searchable()->sortable(),
                TextColumn::make('price_in_usd_cents')
                    ->label('Price')
                    ->money('USD', divideBy: 100)
                    ->sortable(),
                BooleanColumn::make('overridden')->sortable(),
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
            'index' => ListBundlePrices::route('/'),
            'create' => CreateBundlePrice::route('/create'),
            'edit' => EditBundlePrice::route('/{record}/edit'),
        ];
    }
}
