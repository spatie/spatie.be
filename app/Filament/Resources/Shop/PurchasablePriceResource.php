<?php

namespace App\Filament\Resources\Shop;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Shop\PurchasablePriceResource\Pages\ListPurchasablePrices;
use App\Filament\Resources\Shop\PurchasablePriceResource\Pages\CreatePurchasablePrice;
use App\Filament\Resources\Shop\PurchasablePriceResource\Pages\EditPurchasablePrice;
use App\Domain\Shop\Models\PurchasablePrice;
use App\Filament\Resources\Shop\PurchasablePriceResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Support\Paddle\PaddleCountries;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PurchasablePriceResource extends Resource
{
    protected static ?string $model = PurchasablePrice::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Products';

    protected static ?int $navigationSort = 3;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-yen';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('purchasable_id')
                    ->relationship(name: 'purchasable')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->title . ' (' . $record->product->title . ')')
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
                ResourceLinkColumn::make(
                    'purchasable.title',
                    fn (PurchasablePrice $record) => route('filament.admin.resources.shop.purchasables.edit', $record->purchasable)
                )->searchable(),
                TextColumn::make('country_code')
                    ->state(fn (PurchasablePrice $record) => PaddleCountries::getNameForCode($record->country_code) . "($record->country_code)")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('currency_code')->searchable()->sortable(),
                TextColumn::make('amount')
                    ->label('Price')
                    ->money('USD', divideBy: 100)
                    ->sortable(),
                BooleanColumn::make('overridden')->sortable(),
            ])
            ->filters([
                SelectFilter::make('purchasable_id')
                    ->relationship('purchasable', 'title', function ($query) {
                        return $query->with('product');
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title} ({$record->product->title})")
                    ->label('Purchasable')
                    ->searchable(),
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
            'index' => ListPurchasablePrices::route('/'),
            'create' => CreatePurchasablePrice::route('/create'),
            'edit' => EditPurchasablePrice::route('/{record}/edit'),
        ];
    }
}
