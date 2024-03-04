<?php

namespace App\Filament\Resources;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Clue\StreamFilter\fun;

class PurchaseResource extends Resource
{
    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ResourceLinkColumn::make('user.email',
                    fn (Purchase $record) => route('filament.admin.resources.users.edit', $record->user)
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
                        return route('filament.admin.resources.purchasables.edit', $record->purchasable);
                    }

                    if ($record->bundle) {
                        return route('filament.admin.resources.bundles.edit', $record->bundle);
                    }

                    return '';
                }),
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}
