<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->maxFiles(1)
                    ->rules(['image'])
                    ->columnStart(1),
                TextInput::make('title')
                    ->required()
                    ->columnStart(1),
                TextInput::make('slug')
                    ->required()
                    ->columnStart(1),
                TextInput::make('paddle_product_id')
                    ->required()
                    ->columnStart(1),

                MarkdownEditor::make('description')
                    ->columnSpan(2),
                MarkdownEditor::make('long_description')
                    ->columnSpan(2),

                TextInput::make('price_in_usd_cents')
                    ->integer()
                    ->required()
                    ->columnStart(1),

                Toggle::make('visible')
                    ->columnStart(1),

                Select::make('purchasables')
                    ->columnStart(1)
                    ->multiple()
                    ->relationship('purchasables', 'title'),
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
