<?php

namespace App\Filament\Resources\Shop;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Shop\ReferrerResource\Pages\ListReferrers;
use App\Filament\Resources\Shop\ReferrerResource\Pages\CreateReferrer;
use App\Filament\Resources\Shop\ReferrerResource\Pages\EditReferrer;
use App\Domain\Shop\Models\Referrer;
use App\Filament\Resources\Shop\ReferrerResource\Actions\AttachAllPurchasablesToReferrerAction;
use App\Filament\Resources\Shop\ReferrerResource\Pages;
use App\Filament\Tables\Columns\CopyableColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferrerResource extends Resource
{
    protected static ?string $model = Referrer::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';

    protected static string | \UnitEnum | null $navigationGroup = 'Products';

    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                TextColumn::make('id')->searchable()->sortable(),
                CopyableColumn::make('slug')
                    ->formatStateUsing(fn (string $state) => url("/products?referrer={$state}"))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('discount_percentage')
                    ->sortable(),
                TextColumn::make('click_count')
                    ->sortable(),
                TextColumn::make('last_clicked_at')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                AttachAllPurchasablesToReferrerAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListReferrers::route('/'),
            'create' => CreateReferrer::route('/create'),
            'edit' => EditReferrer::route('/{record}/edit'),
        ];
    }
}
