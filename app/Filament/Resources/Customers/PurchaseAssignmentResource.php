<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers;
use App\Filament\Resources\PurchaseAssignmentResource\Pages;
use App\Filament\Resources\PurchaseAssignmentResource\RelationManagers;
use App\Models\PurchaseAssignment;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseAssignmentResource extends Resource
{
    protected static ?string $model = PurchaseAssignment::class;

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
            'index' => Customers\PurchaseAssignmentResource\Pages\ListPurchaseAssignments::route('/'),
            'create' => Customers\PurchaseAssignmentResource\Pages\CreatePurchaseAssignment::route('/create'),
            'edit' => Customers\PurchaseAssignmentResource\Pages\EditPurchaseAssignment::route('/{record}/edit'),
        ];
    }
}
