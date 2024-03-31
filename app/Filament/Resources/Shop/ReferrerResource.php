<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Models\Referrer;
use App\Filament\Resources\Shop\ReferrerResource\Actions\AttachAllPurchasablesToReferrerAction;
use App\Filament\Resources\Shop\ReferrerResource\Pages;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferrerResource extends Resource
{
    protected static ?string $model = Referrer::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('id')
                            ->disabled(),
                        TextInput::make('uuid')
                            ->disabled(),
                        TextInput::make('slug')
                            ->columnStart(1)
                            ->required(),
                        TextInput::make('discount_percentage')
                            ->integer()
                            ->columnStart(1)
                            ->required(),
                        DateTimePicker::make('discount_period_ends_at')
                            ->columnStart(1)
                            ->required(),
                        TextInput::make('click_count')
                            ->columnStart(1)
                            ->disabled(),
                        DateTimePicker::make('last_clicked_at')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->formatStateUsing(fn (string $state) => url("/products?referrer={$state}"))
                    ->icon('heroicon-m-clipboard-document-list')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->sortable(),
                Tables\Columns\TextColumn::make('click_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_clicked_at')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                AttachAllPurchasablesToReferrerAction::make(),
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
            'index' => Pages\ListReferrers::route('/'),
            'create' => Pages\CreateReferrer::route('/create'),
            'edit' => Pages\EditReferrer::route('/{record}/edit'),
        ];
    }
}
