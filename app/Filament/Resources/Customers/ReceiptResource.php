<?php

namespace App\Filament\Resources\Customers;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Customers\ReceiptResource\Pages\ListReceipts;
use App\Filament\Resources\Customers\ReceiptResource\Pages\CreateReceipt;
use App\Filament\Resources\Customers\ReceiptResource\Pages\EditReceipt;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Laravel\Paddle\Receipt;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Customers';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('id')
                            ->disabled(),
                        Select::make('billable_id')
                            ->relationship(name: 'billable')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->email ?? '')
                            ->searchable(['email'])
                            ->columnStart(1),
                        TextInput::make('receipt_url')
                            ->columnStart(1),
                        TextInput::make('amount')
                            ->numeric()
                            ->columnStart(1),
                        TextInput::make('tax')
                            ->numeric()
                            ->columnStart(1),
                        TextInput::make('currency')
                            ->columnStart(1),
                        TextInput::make('billable_type')
                            ->readOnly()
                            ->columnStart(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('billable.email')->searchable()->label('User'),
                TextColumn::make('amount'),
                TextColumn::make('currency'),
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
            'index' => ListReceipts::route('/'),
            'create' => CreateReceipt::route('/create'),
            'edit' => EditReceipt::route('/{record}/edit'),
        ];
    }
}
