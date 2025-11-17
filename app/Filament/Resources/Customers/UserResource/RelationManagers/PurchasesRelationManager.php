<?php

namespace App\Filament\Resources\Customers\UserResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Domain\Shop\Models\Purchase;
use App\Filament\Resources\Customers\PurchaseResource\Columns\BoughtColumn;
use App\Filament\Tables\Columns\CopyableColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchasesRelationManager extends RelationManager
{
    protected static string $relationship = 'purchases';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->disabled()
                    ->maxLength(255),
                Select::make('user_id')
                    ->relationship(name: 'user')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->email ?? '')
                    ->searchable(['email'])
                    ->columnStart(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')->disabled(),
                BoughtColumn::make(),
                ResourceLinkColumn::make('receipt.id', fn (Purchase $record) => $record->receipt ? route('filament.admin.resources.customers.receipts.edit', $record->receipt) : ''),
                CopyableColumn::make('receipt')
                    ->state(function (Purchase $record) {
                        if (! $record->receipt) {
                            return '';
                        }

                        $exploded = explode('/', $record->receipt->receipt_url);

                        return $exploded[4] ?? '-';
                    })
                    ->label('Paddle ID'),
                TextColumn::make('assignments.user.email')
                    ->label('Assignments')
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('purchasable')
                    ->relationship('purchasable', 'title')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('bundle')
                    ->relationship('bundle', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
