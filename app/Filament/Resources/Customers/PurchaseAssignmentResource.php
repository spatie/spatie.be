<?php

namespace App\Filament\Resources\Customers;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Filament\Resources\Customers;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseAssignmentResource extends Resource
{
    protected static ?string $model = PurchaseAssignment::class;

    protected static ?string $navigationGroup = 'Customers';

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

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
                TextColumn::make('id')->sortable(),
                ResourceLinkColumn::make('purchase.id',
                    fn(PurchaseAssignment $record) => route('filament.admin.resources.customers.purchases.edit', $record->purchase)
                )
                    ->state(fn(PurchaseAssignment $record) => '#' . $record->purchase->id . ' on ' . $record->purchase->created_at)
                    ->sortable(),
                TextColumn::make('purchasable.title')->sortable()->searchable(),
                TextColumn::make('user.email')->sortable()->searchable(),
                BooleanColumn::make('has_repository_access')->sortable(),
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
