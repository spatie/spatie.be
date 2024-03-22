<?php

namespace App\Filament\Resources\Customers\UserResource\RelationManagers;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Resources\Customers\PurchaseResource\Columns\BoughtColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchasesRelationManager extends RelationManager
{
    protected static string $relationship = 'purchases';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
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
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')->disabled(),
                BoughtColumn::make(),
                TextColumn::make('assignments.user.email')
                    ->label('Assignments')
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('created_at')
                    ->dateTime(),
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
