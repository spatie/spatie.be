<?php

namespace App\Filament\Resources\Customers\UserResource\RelationManagers;

use App\Domain\Shop\Models\License;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LicensesRelationManager extends RelationManager
{
    protected static string $relationship = 'licenses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                TextColumn::make('key')
                    ->copyable()
                    ->icon('heroicon-o-document-duplicate')
                    ->iconPosition(IconPosition::After)
                    ->searchable(),
                TextColumn::make('satis_authentication_count')->sortable(),
                TextColumn::make('expires_at')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
