<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\PurchasablePrice;
use App\Filament\Resources\Shop\PurchasablePriceResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Support\Paddle\PaddleCountries;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                TextColumn::make('price_in_usd_cents')
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
