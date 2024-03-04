<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\BundleResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BundleResource extends Resource
{
    protected static ?string $model = Bundle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
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
