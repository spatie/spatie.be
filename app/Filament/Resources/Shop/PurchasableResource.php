<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Purchasable;
use App\Filament\Resources\Shop;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchasableResource extends Resource
{
    protected static ?string $model = Purchasable::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
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
            'index' => Shop\PurchasableResource\Pages\ListPurchasables::route('/'),
            'create' => Shop\PurchasableResource\Pages\CreatePurchasable::route('/create'),
            'edit' => Shop\PurchasableResource\Pages\EditPurchasable::route('/{record}/edit'),
        ];
    }
}
