<?php

namespace App\Filament\Resources\Customers\UserResource\RelationManagers;

use App\Filament\Tables\Columns\CopyableColumn;
use App\Filament\Tables\Columns\LicensePurchasableNameColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LicensesRelationManager extends RelationManager
{
    protected static string $relationship = 'licenses';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('expires_at')
                    ->columnStart(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id'),
                LicensePurchasableNameColumn::make(),
                CopyableColumn::make('key')
                    ->searchable(),
                TextColumn::make('satis_authentication_count')->sortable(),
                TextColumn::make('expires_at')->date()->sortable(),
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
