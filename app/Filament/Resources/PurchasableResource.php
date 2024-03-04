<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchasableResource\Pages;
use App\Filament\Resources\PurchasableResource\RelationManagers;
use App\Models\Purchasable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
            'index' => Pages\ListPurchasables::route('/'),
            'create' => Pages\CreatePurchasable::route('/create'),
            'edit' => Pages\EditPurchasable::route('/{record}/edit'),
        ];
    }
}
