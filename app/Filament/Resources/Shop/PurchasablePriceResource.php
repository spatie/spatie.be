<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\PurchasablePrice;
use App\Filament\Resources\Shop\PurchasablePriceResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Support\Paddle\PaddleCountries;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchasablePriceResource extends Resource
{
    protected static ?string $model = PurchasablePrice::class;

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-currency-yen';

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
                ResourceLinkColumn::make('purchasable.title', fn (PurchasablePrice $record) => route('filament.admin.resources.shop.purchasables.edit', $record->purchasable)),
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
            'index' => Pages\ListPurchasablePrices::route('/'),
            'create' => Pages\CreatePurchasablePrice::route('/create'),
            'edit' => Pages\EditPurchasablePrice::route('/{record}/edit'),
        ];
    }
}
