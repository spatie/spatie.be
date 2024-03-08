<?php

namespace App\Filament\Resources\Customers;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseResource extends Resource
{
    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('id')
                            ->disabled(),
                        Select::make('user_id')
                            ->relationship(name: 'user')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->email ?? '')
                            ->searchable(['email'])
                            ->columnStart(1),
                        Select::make('purchasable_id')
                            ->relationship(name: 'purchasable', titleAttribute: 'title')
                            ->searchable(['title'])
                            ->columnStart(1),
                        Select::make('bundle_id')
                            ->relationship(name: 'bundle', titleAttribute: 'title')
                            ->searchable(['title']),
                        Select::make('receipt_id')
                            ->relationship(name: 'receipt', titleAttribute: 'id')
                            ->searchable(['id']),
                        TextInput::make('earnings')->columnStart(1),
                        TextInput::make('paddle_fee'),
                        DatePicker::make('created_at')
                            ->disabled()
                            ->columnStart(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ResourceLinkColumn::make(
                    'user.email',
                    fn (Purchase $record) => route('filament.admin.resources.customers.users.edit', $record->user)
                ),
                ResourceLinkColumn::make('Bought')->state(function (Purchase $record) {
                    if ($record->purchasable) {
                        return $record->purchasable->title;
                    }

                    if ($record->bundle) {
                        return $record->bundle->title;
                    }

                    return '-';
                })->url(function (Purchase $record) {
                    if ($record->purchasable) {
                        return route('filament.admin.resources.shop.purchasables.edit', $record->purchasable);
                    }

                    if ($record->bundle) {
                        return route('filament.admin.resources.shop.bundles.edit', $record->bundle);
                    }

                    return '';
                }),
                TextColumn::make('assignments.user.email')
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('created_at')
                    ->dateTime(),
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
            'index' => \App\Filament\Resources\Customers\PurchaseResource\Pages\ListPurchases::route('/'),
            'create' => \App\Filament\Resources\Customers\PurchaseResource\Pages\CreatePurchase::route('/create'),
            'edit' => \App\Filament\Resources\Customers\PurchaseResource\Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}
