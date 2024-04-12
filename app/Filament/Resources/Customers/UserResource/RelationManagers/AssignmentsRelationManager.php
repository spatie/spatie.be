<?php

namespace App\Filament\Resources\Customers\UserResource\RelationManagers;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Filament\Resources\Customers\PurchaseResource\Columns\BoughtColumn;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('id'),
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
