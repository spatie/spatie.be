<?php

namespace App\Filament\Resources\Customers;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Laravel\Paddle\Receipt;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            'index' => \App\Filament\Resources\Customers\ReceiptResource\Pages\ListReceipts::route('/'),
            'create' => \App\Filament\Resources\Customers\ReceiptResource\Pages\CreateReceipt::route('/create'),
            'edit' => \App\Filament\Resources\Customers\ReceiptResource\Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
