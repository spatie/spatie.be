<?php

namespace App\Filament\Resources\Customers;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Resources\Customers\PurchaseResource\Actions\TransferPurchaseAction;
use App\Filament\Resources\Customers\PurchaseResource\Columns\BoughtColumn;
use App\Filament\Tables\Columns\CopyableColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
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
            ->defaultSort('created_at', 'desc')
            ->columns([
                ResourceLinkColumn::make(
                    'user.email',
                    fn (Purchase $record) => route('filament.admin.resources.customers.users.edit', $record->user)
                )
                    ->iconPosition(IconPosition::After)
                    ->copyable()
                    ->icon('heroicon-o-document-duplicate')
                    ->searchable()
                    ->sortable(),
                ResourceLinkColumn::make('receipt.id', fn (Purchase $record) => route('filament.admin.resources.customers.receipts.edit', $record->receipt)),
                CopyableColumn::make('receipt')
                    ->state(function (Purchase $record) {
                        $exploded = explode('/', $record->receipt->receipt_url);

                        return $exploded[4] ?? '-';
                    })
                    ->label('Paddle ID'),
                BoughtColumn::make(),
                TextColumn::make('assignments.user.email')
                    ->label('Assignments')
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('purchasable')
                    ->relationship('purchasable', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('bundle')
                    ->relationship('bundle', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                TransferPurchaseAction::make(),
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
