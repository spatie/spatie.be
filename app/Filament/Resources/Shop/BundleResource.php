<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Bundle;
use App\Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BundleResource extends Resource
{
    protected static ?string $model = Bundle::class;

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('paddle_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price_in_usd_cents')->sortable(),
                BooleanColumn::make('visible')->label('Visible on Front')->sortable(),
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
            'index' => BundleResource\Pages\ListBundles::route('/'),
            'create' => BundleResource\Pages\CreateBundle::route('/create'),
            'edit' => BundleResource\Pages\EditBundle::route('/{record}/edit'),
        ];
    }
}
