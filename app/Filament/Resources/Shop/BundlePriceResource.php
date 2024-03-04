<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\BundlePrice;
use App\Domain\Shop\Models\PurchasablePrice;
use App\Filament\Resources\Shop\BundlePriceResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Support\Paddle\PaddleCountries;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BundlePriceResource extends Resource
{
    protected static ?string $model = BundlePrice::class;

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-currency-rupee';

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
                ResourceLinkColumn::make('bundle.title', fn (PurchasablePrice $record) => route('filament.admin.resources.shop.purchasables.edit', $record->purchasable)),
                Tables\Columns\TextColumn::make('country')->state(fn (PurchasablePrice $record) => PaddleCountries::getNameForCode($record->country_code) . "($record->country_code)")->searchable()->sortable(),
                Tables\Columns\TextColumn::make('currency_code')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price_in_usd_cents')->sortable(),
                BooleanColumn::make('overridden')->sortable(),
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
            'index' => Pages\ListBundlePrices::route('/'),
            'create' => Pages\CreateBundlePrice::route('/create'),
            'edit' => Pages\EditBundlePrice::route('/{record}/edit'),
        ];
    }
}
