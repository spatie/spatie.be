<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\BundlePrice;
use App\Domain\Shop\Models\PurchasablePrice;
use App\Filament\Resources\Shop\BundlePriceResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Support\Paddle\PaddleCountries;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                ResourceLinkColumn::make('bundle.title', fn (BundlePrice $record) => route('filament.admin.resources.shop.bundles.edit', $record->bundle)),
                Tables\Columns\TextColumn::make('country')->state(fn (BundlePrice $record) => PaddleCountries::getNameForCode($record->country_code) . "($record->country_code)")->searchable()->sortable(),
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
