<?php

namespace App\Filament\Resources\Customers\UserResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Filament\Resources\Customers\PurchaseResource\Columns\BoughtColumn;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id'),
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
