<?php

namespace App\Filament\Resources\Customers;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use App\Filament\Resources\Customers\PurchaseResource\Columns\BoughtColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Customers\PurchaseAssignmentResource\Pages\ListPurchaseAssignments;
use App\Filament\Resources\Customers\PurchaseAssignmentResource\Pages\CreatePurchaseAssignment;
use App\Filament\Resources\Customers\PurchaseAssignmentResource\Pages\EditPurchaseAssignment;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Filament\Resources\Customers;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseAssignmentResource extends Resource
{
    protected static ?string $model = PurchaseAssignment::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Customers';

    protected static ?int $navigationSort = 8;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('id')
                            ->disabled(),

                        Select::make('user_id')
                            ->relationship(name: 'user')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->email ?? '')
                            ->searchable(['email'])
                            ->columnStart(1),

                        Select::make('purchase_id')
                            ->relationship(name: 'purchase')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->id ?? '')
                            ->searchable(['title'])
                            ->columnStart(1),

                        Select::make('purchasable_id')
                            ->relationship(name: 'purchasable')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->title ?? '')
                            ->searchable(['title'])
                            ->columnStart(1),

                        Checkbox::make('has_repository_access')
                            ->disabled()
                            ->inline()
                            ->columnStart(1),

                        DateTimePicker::make('created_at')
                            ->disabled()
                            ->columnStart(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ResourceLinkColumn::make(
                    'purchase.id',
                    fn (PurchaseAssignment $record) => route('filament.admin.resources.customers.purchases.edit', $record->purchase)
                )
                    ->state(fn (PurchaseAssignment $record) => '#' . $record->purchase->id . ' on ' . $record->purchase->created_at)
                    ->sortable(),
                BoughtColumn::make(),
                TextColumn::make('user.email')->sortable()->searchable(),
                BooleanColumn::make('has_repository_access')->sortable(),
            ])
            ->filters([
                //
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
            'index' => ListPurchaseAssignments::route('/'),
            'create' => CreatePurchaseAssignment::route('/create'),
            'edit' => EditPurchaseAssignment::route('/{record}/edit'),
        ];
    }
}
